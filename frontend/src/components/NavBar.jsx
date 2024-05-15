import React, { Component } from 'react'
import CartOverlay from './CartOverlay'
import './Navbar.css'

/**
 * Navbar component for displaying the navigation bar and cart overlay.
 */

class Navbar extends Component {

  /**
   * Renders the Navbar component.
   *
   * This method renders the navigation bar with category buttons,
   * the logo, and the cart button with the item count. It also
   * conditionally renders the CartOverlay component.
   *
   * @returns {React.Element} The rendered component.
   */

  render() {

    const { toggleCart, isCartOpen, cartItems, handleCatagoryClick, handleOrderButton, increaseQuantity, decreaseQuantity, categories } = this.props
    const itemCount = cartItems.reduce((total, item) => total + item.quantity, 0)

    if(!categories.categories) {
      return null
    }

    return (
      <nav className="navbar">
        <ul className="navbar-nav">
          {categories.categories.map((category) =>
            <li className="nav-item" key={category.name}>
              <button onClick={() => handleCatagoryClick(category.name.toUpperCase())}>
                {category.name.toUpperCase()}
              </button>
            </li>
          )}
        </ul>
        <div className="navbar-logo">
          <span className="material-icons">local_mall</span>
        </div>
        <div className="navbar-cart">
          <button onClick={toggleCart}>
            <span className="material-symbols-outlined">shopping_cart</span>
            {itemCount > 0 && <span className="cart-item-count">{itemCount}</span>}
          </button>
          {isCartOpen ? <CartOverlay isCartOpen={isCartOpen} items={cartItems} increaseQuantity={increaseQuantity} decreaseQuantity={decreaseQuantity} handleOrderButton={handleOrderButton} toggleCart={toggleCart} /> : null}
        </div>
      </nav>
    )
  }
}

export default Navbar
