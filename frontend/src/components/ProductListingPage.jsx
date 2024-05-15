import React, { Component } from 'react'
import Header from './Header'
import CardGrid from './CardGrid'

/**
 * ProductListingPage component for displaying a list of products.
 */

class ProductListingPage extends Component {

  /**
   * Renders the ProductListingPage component.
   *
   * This method renders the Header and CardGrid components, passing the relevant
   * props to them. It also includes an overlay that can be toggled on and off.
   *
   * @returns {React.Element} The rendered component.
   */

  render() {
    const { header, jsonData, isCartOpen, toggleCart, handleCardClick, handleAddToCart } = this.props
    return (
      <div className="content-container">
        <Header header={header} />
        {jsonData ? (
          <CardGrid
            handleCardClick={handleCardClick}
            products={jsonData.products}
            isCartOpen={isCartOpen}
            toggleCart={toggleCart}
            handleAddToCart={handleAddToCart}
          />
        ) : null}
        <div className={`overlay ${!isCartOpen ? 'hidden' : ''}`} onClick={toggleCart}></div>
      </div>
    )
  }
}

export default ProductListingPage
