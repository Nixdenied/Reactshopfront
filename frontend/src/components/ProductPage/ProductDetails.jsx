import React, { Component } from 'react'
import parse from 'html-react-parser'
import DOMPurify from 'dompurify'
import './ProductDetails.css'
import ProductAttributes from './ProductAttributes'

/**
 * ProductDetails component for displaying detailed information about a product.
 */

class ProductDetails extends Component {

  /**
   * Constructs the ProductDetails component.
   *
   * This constructor initializes the state with selected options.
   *
   * @param {Object} props - The properties passed to the component.
   */

  constructor(props) {
    super(props)
    this.state = {
      selectedOptions: null,
    }
  }

  /**
   * Handles the selection of a product attribute.
   *
   * This method updates the state with the selected attribute option.
   *
   * @param {string} name - The name of the attribute.
   * @param {string} value - The selected value of the attribute.
   */

  handleSelectAttribute = (name, value) => {
    this.setState(prevState => ({
      selectedOptions: {
        ...prevState.selectedOptions,
        [name]: value,
      },
    }))
  }

  /**
   * Determines if the "Add to Cart" button should be disabled.
   *
   * This method checks the product's stock status and whether all attributes have been selected.
   *
   * @returns {boolean} True if the button should be disabled, false otherwise.
   */

  isButtonDisabled = () => {
    const { product } = this.props
    const { selectedOptions } = this.state

    if (!product.inStock) {
      return true
    }

    if (!selectedOptions || Object.keys(selectedOptions).length === 0) {
      return true
    }

    if (Object.keys(selectedOptions).length !== product.attributes.length) {
      return true
    }

    return false
  }

  /**
   * Handles the click event for adding the product to the cart.
   *
   * This method creates an order object with the product and selected options, and
   * triggers the handleAddToCart function passed in as a prop.
   */

  handleAddClick = () => {
    const { product } = this.props
    const { selectedOptions } = this.state
    const order = {
      ...product,
      selectedOptions,
    }
    this.props.handleAddToCart(product, order)
  }

  /**
   * Renders the ProductDetails component.
   *
   * This method renders the product details, including its name, attributes, price,
   * and description. It also includes an "Add to Cart" button with appropriate state.
   *
   * @returns {React.Element} The rendered component.
   */

  render() {
    const { product } = this.props
    const cleanDescription = DOMPurify.sanitize(product.description)

    return (
      <div className="product-details">
        <h2 className="product-title">{product.name}</h2>
        <ProductAttributes attributes={product.attributes} onSelectAttribute={this.handleSelectAttribute} />
        <div className="product-text-header">Price:</div>
        <div className='product-price'>{product.prices[0].currency.symbol}{parseFloat(product.prices[0].amount).toFixed(2)}</div>
        <button className={this.isButtonDisabled() ? 'disabled-add-to-cart-button' : 'add-to-cart-button'} disabled={this.isButtonDisabled() ? true : false} onClick={this.handleAddClick}>ADD TO CART</button>
        <div className="product-description">{parse(cleanDescription)}</div>
      </div>
    )
  }
}

export default ProductDetails
