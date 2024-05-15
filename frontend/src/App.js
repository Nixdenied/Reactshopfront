import React, { Component } from 'react'
import './App.css'
import NavBar from './components/NavBar'
import ProductListingPage from './components/ProductListingPage'
import ProductPage from './components/ProductPage'
import Product from './services/products'
import Order from './services/order'
import Categories from './services/categories'
import { withRouter, Route, Switch } from 'react-router-dom'
import { v4 as uuidv4 } from 'uuid'
import { calculateTotal, extractCurrency, mapOrderItems } from './utils/utilities'

/**
 * The App component serves as the root component for the application.
 * It manages the overall state, handles routing, and provides essential methods for cart operations.
 */

class App extends Component {

  /**
   * Constructs the App component.
   *
   * Initializes state, binds methods, and sets up service instances.
   *
   * @param {Object} props - The properties passed to the component.
   */

  constructor(props) {
    super(props)
    this.state = {
      jsonData: null,
      initialData: null,
      isCartOpen: false,
      cartItems: [],
      header: 'ALL',
      categories: [],
    }
    //https://hourly-compressions.000webhostapp.com/graphql
    const url = 'http://localhost:80/graphql'

    this.categoriesService = new Categories(url)
    this.orderService = new Order(url)
    this.productService = new Product(url)
    this.toggleCart = this.toggleCart.bind(this)
  }

  /**
   * Stores cartItems to localstorage on component update
   */

  componentDidUpdate() {
    localStorage.setItem('cartItems', JSON.stringify(this.state.cartItems));
  }

  /**
   * Toggles the cart visibility state.
   */

  toggleCart = () => {
    this.setState(prevState => ({
      isCartOpen: !prevState.isCartOpen,
    }))
  }

  /**
   * Increases the quantity of a specific item in the cart.
   *
   * @param {string} uuid - The unique identifier of the cart item.
   */

  increaseQuantity = (uuid) => {
    this.setState(prevState => ({
      cartItems: prevState.cartItems.map(item =>
        item.uuid === uuid ? { ...item, quantity: item.quantity + 1 } : item,
      ),
    }))
  }

  /**
   * Decreases the quantity of a specific item in the cart.
   *
   * If the quantity is less than 1, the item is removed from the cart.
   *
   * @param {string} uuid - The unique identifier of the cart item.
   */

  decreaseQuantity = (uuid) => {
    this.setState(prevState => ({
      cartItems: prevState.cartItems.reduce((acc, item) => {
        if (item.uuid === uuid) {
          if (item.quantity > 1) {
            acc.push({ ...item, quantity: item.quantity - 1 })
          }
        } else {
          acc.push(item)
        }
        return acc
      }, []),
    }))
  }

  /**
   * Handles the selection of a category.
   *
   * Filters the product data based on the selected category and updates the state.
   * 
   * If a category button is pushed while in ProductPage, this will handle going back to Product Listing root dir '/'
   *
   * @param {string} category - The selected category.
   */

  handleCategoryClick = (category) => {

    this.setState({ header: category })

    if (this.props.location.pathname !== '/') {
      this.props.history.push('/')
    }

    if (!this.state.jsonData) {
      return
    }

    if (category.toLowerCase() === 'all') {
      this.setState({ jsonData: this.state.initialData })
      return
    }

    const filteredData = this.state.initialData.products.filter(item =>
      item.category.toLowerCase() === category.toLowerCase(),
    )

    this.setState({ jsonData: { products: filteredData } })
  }

  /**
   * Handles the click event on a product card.
   *
   * @param {Object} e - The event object.
   * @param {Object} product - The product data.
   */

  handleCardClick = (e, product) => {
    this.setState({ ProductPageData: product })
  }


  /**
   * Handles the order button click event.
   *
   * Creates an order and resets the cart.
   */

  handleOrderButton = async () => {
    const customer_id = 1
    const status = 'pending'

    const order_items = mapOrderItems(this.state.cartItems)
    const currency = extractCurrency(this.state.cartItems)
    const totalAmount = calculateTotal(this.state.cartItems, currency)

    const orderData = {
      orders: [
        {
          customer_id,
          status,
          order_items,
          order_payments: {
            amount: totalAmount,
            currency,
            payment_method: 'Credit Card',
          },
        },
      ],
    }

    try {
      await this.orderService.createOrder(orderData)
      this.setState({ cartItems: [] })
      this.toggleCart()
    } catch (error) {
      throw new Error('Order error:', error)
    }
  }

  /**
   * Handles the addition of an item to the cart.
   *
   * @param {Object} item - The item to be added.
   * @param {Object} order - The order data.
   */

  handleAddToCart = (item, order) => {

    if (!order) {
      order = {
        ...item,
        selectedOptions: {},
      }

      if (item.attributes) {
        item.attributes.forEach(attr => {
          order.selectedOptions[attr.name] = attr.items[0].value
        })
      }
    }

    if (!order.uuid) {
      order.uuid = uuidv4()
    }

    this.setState(prevState => {
      const existingItem = prevState.cartItems.find(cartItem =>
        cartItem.id === order.id && JSON.stringify(cartItem.selectedOptions) === JSON.stringify(order.selectedOptions),
      )

      if (existingItem) {
        return {
          cartItems: prevState.cartItems.map(cartItem =>
            cartItem.id === order.id ? { ...cartItem, quantity: cartItem.quantity + 1 } : cartItem,
          ),
        }
      } else {
        return {
          cartItems: [...prevState.cartItems, { ...order, quantity: 1 }],
        }
      }
    })
  }

  /**
   * Lifecycle method called after the component is mounted.
   *
   * Initiates data fetching.
   * 
   * Gets cartItems from localstorage if there is any, if not it returns an empty array
   */

  componentDidMount() {
    this.fetchData()
    this.fetchCategories()
    const savedCartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    this.setState({ cartItems: savedCartItems });


  }

  /**
   * Fetches the product data from the service.
   *
   * Updates the state with the fetched data.
   */

  async fetchData() {
    try {
      const response = await this.productService.fetchAllProducts()
      this.setState({ jsonData: response, initialData: response })
    } catch (error) {
      throw new Error('Error fetching data:', error)
    }
  }

  async fetchCategories() {
    try {
      const response = await this.categoriesService.fetchAllCategories()
      this.setState({ categories: response })
    } catch (error) {
      throw new Error('Error fetching categories', error)
    }
  }

  /**
   * Renders the App component.
   *
   * This method renders the NavBar and routes for product listing and product page.
   *
   * @returns {React.Element} The rendered component.
   */

  render() {

    const { jsonData, isCartOpen, cartItems, header, categories } = this.state

    return (
      <>
        <NavBar
          isCartOpen={isCartOpen}
          toggleCart={this.toggleCart}
          cartItems={cartItems}
          handleCatagoryClick={this.handleCategoryClick}
          handleOrderButton={this.handleOrderButton}
          increaseQuantity={this.increaseQuantity}
          decreaseQuantity={this.decreaseQuantity}
          categories={categories}
        />
        <Switch>
          <Route exact path="/" render={(props) => (
            <ProductListingPage
              {...props}
              header={header}
              jsonData={jsonData}
              isCartOpen={isCartOpen}
              toggleCart={this.toggleCart}
              handleCardClick={this.handleCardClick}
              handleAddToCart={this.handleAddToCart}
            />
          )} />
          <Route path="/product/:productId" render={(props) => (
            <ProductPage
              {...props}
              productService={this.productService}
              handleAddToCart={this.handleAddToCart}
            />
          )} />
        </Switch>
      </>
    )
  }
}

export default withRouter(App)
