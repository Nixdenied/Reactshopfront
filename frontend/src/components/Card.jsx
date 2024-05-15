import React, { Component } from 'react'
import './Card.css'
import './CardGrid.css'
import { Link } from 'react-router-dom'

/**
 * Card component for displaying individual product details in a card format.
 */

class Card extends Component {

  /**
   * Renders the Card component.
   *
   * This method renders the product details within a card, including an image,
   * name, price, and an "Add to Cart" button if the product is in stock.
   *
   * @returns {React.Element} The rendered component.
   */

  render() {
    const { handleCardClick, product, handleAddToCart } = this.props

    /**
     * Handles adding the product to the cart.
     *
     * This function prevents the default link behavior and triggers the
     * handleAddToCart function passed in as a prop.
     *
     * @param {Event} e - The event object.
     * @param {Object} product - The product to be added to the cart.
     */

    const addToCart = (e, product) => {
      e.preventDefault()
      handleAddToCart(product)
    }

    return (
      <Link onClick={(e) => {handleCardClick(e, product)}} to={`/product/${product.index}`} style={{ textDecoration: 'none', color: 'black' }}>
        <div className="card">
          {!product.inStock && (
            <div className="out-of-stock-overlay">
                Out of Stock
            </div>
          )}
          <img className="card-image" src={product.gallery[0]} alt={product.name} />
          {product.inStock && <button className="add-to-cart-btn" onClick={(e) => addToCart(e, product)}>
            <span className="material-symbols-outlined">shopping_cart</span>
          </button>}
          <p className="card-content">
            {product.name}
            <br />
            <b>
              {product.prices[0].currency.symbol}
              {product.prices[0].amount}
            </b>
          </p>
        </div>
      </Link>

    )
  }
}

export default Card
