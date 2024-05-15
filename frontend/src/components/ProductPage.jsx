import React, { Component } from 'react'
import ImageCarousel from './ProductPage/ImageCarousel'
import ProductDetails from './ProductPage/ProductDetails'
import './ProductPage.css'

class ProductPage extends Component {

  /**
   * Constructs the ProductPage component.
   *
   * This constructor initializes the state of the ProductPage component,
   * including the product data and the selected image.
   *
   * @param {Object} props - The properties passed to the component.
   */

  constructor(props) {
    super(props)
    this.state = {
      product: null,
      selectedImage: '',
    }
  }

  /**
   * Handles the image selection.
   *
   * This method updates the state with the selected image.
   *
   * @param {string} image - The URL of the selected image.
   */

  handleImageSelect = image => {
    this.setState({ selectedImage: image })
  }


  /**
   * Lifecycle method called after the component is mounted.
   *
   * This method triggers the fetchProduct method to retrieve the product data.
   */

  componentDidMount() {
    this.fetchProduct()
  }

  /**
   * Fetches the product data.
   *
   * This method retrieves the product data based on the productId from the URL parameters.
   * It updates the state with the product data and the first image from the gallery.
   *
   * @async
   */

  fetchProduct = async () => {
    const { productId } = this.props.match.params
    if (!productId) {
      return this.setState({ product: null })
    }

    try {
      const product = await this.props.productService.fetchProduct(productId)

      if (product && product.gallery && product.gallery.length > 0) {
        this.setState({
          product: product,
          selectedImage: product.gallery[0],
        })
      } else {
        this.setState({ product: null })
      }
    } catch (error) {
      this.setState({ product: null })
    }
  }

  /**
   * Renders the ProductPage component.
   *
   * This method renders the ImageCarousel and ProductDetails components,
   * passing the relevant props to them.
   *
   * @returns {React.Element|null} The rendered component.
   */

  render() {
    const { selectedImage, product } = this.state
    const { handleAddToCart } = this.props

    if (!product) {
      return null
    }

    return (
      <div className="product-container">
        <ImageCarousel
          gallery={product.gallery}
          selectedImage={selectedImage}
          onImageSelect={this.handleImageSelect}
        />
        <ProductDetails product={product} handleAddToCart={handleAddToCart} />
      </div>
    )
  }
}

export default ProductPage
