import React, { Component } from 'react'
import Card from './Card'
import './CardGrid.css'

/**
 * CardGrid component for displaying a grid of product cards.
 */

class CardGrid extends Component {
  
  /**
   * Renders the CardGrid component.
   *
   * This method renders a grid of product cards, passing the relevant
   * props to each Card component.
   *
   * @returns {React.Element} The rendered component.
   */

  render() {
    const { handleCardClick, products, handleAddToCart } = this.props

    return (
      <>
        <div className="card-grid">
          {products.map((product) => (
            <Card
              key={product.id}
              handleCardClick={handleCardClick}
              product={product}
              handleAddToCart={handleAddToCart}
            />
          ))}
        </div>
      </>
    )
  }
}

export default CardGrid
