import React, { Component } from 'react'
import './CartOverlay.css'
import { calculateTotal, calculateTotalItems } from '../utils/utilities'

/**
 * CartOverlay component for displaying the shopping cart overlay.
 */

class CartOverlay extends Component {

    /**
     * Constructs the CartOverlay component.
     *
     * This constructor initializes the cartRef for detecting clicks outside
     * the cart overlay.
     *
     * @param {Object} props - The properties passed to the component.
     */

    constructor(props) {
        super(props)
        this.cartRef = React.createRef()
    }

    /**
     * Lifecycle method called after the component is mounted.
     *
     * This method adds an event listener for detecting clicks outside the cart overlay.
     */

    componentDidMount() {
        document.addEventListener('mousedown', this.handleClickOutside)
    }

    /**
     * Lifecycle method called before the component is unmounted.
     *
     * This method removes the event listener for detecting clicks outside the cart overlay.
     */

    componentWillUnmount() {
        document.removeEventListener('mousedown', this.handleClickOutside)
    }

    /**
     * Handles clicks outside the cart overlay.
     *
     * This method toggles the cart overlay if a click is detected outside of it.
     *
     * @param {MouseEvent} event - The mouse event.
     */

    handleClickOutside = (event) => {
        if (this.cartRef && !this.cartRef.current.contains(event.target)) {
            this.props.toggleCart()
        }
    }

    /**
     * Renders the CartOverlay component.
     *
     * This method renders the cart overlay, including the items in the cart,
     * their details, and the total cost. It also includes buttons for increasing
     * and decreasing item quantities and placing the order.
     *
     * @returns {React.Element} The rendered component.
     */

    render() {
        const { items, decreaseQuantity, increaseQuantity, handleOrderButton } = this.props
        const totalCost = calculateTotal(items)
        const totalItems = calculateTotalItems(items)

        return (
            <div className='cart' ref={this.cartRef}>
                <div className='cart-header'>
                    <p>My Bag, {totalItems} {totalItems === 1 ? 'item' : 'items'}</p>
                </div>
                <div className="cart-content">
                    {items.map((item, index) => (
                        <div key={index} className="cart-item">
                            <div className="left-column">
                                <div className="item-details">
                                    <p className="item-name">{item.name}</p>
                                    <p className="item-price">${item.prices[0].amount.toFixed(2)}</p>
                                    {item.attributes.map(attr => (
                                        <div key={attr.id}>
                                            {attr.name.toLowerCase() === 'color' ? (
                                                <div className="colors">
                                                    <p>
                                                        {attr.name}:
                                                        <button className="color-btn" style={{ backgroundColor: item.selectedOptions[attr.name] }}>

                                                        </button>
                                                    </p>
                                                </div>
                                            ) : (
                                                <p>{attr.name}: {item.selectedOptions[attr.name]}</p>
                                            )}
                                        </div>
                                    ))}
                                </div>
                            </div>
                            <div className="middle-column">
                                <button className="quantity-btn" onClick={() => increaseQuantity(item.uuid)}>+</button>
                                <span className="quantity">{item.quantity}</span>
                                <button className="quantity-btn" onClick={() => decreaseQuantity(item.uuid)}>-</button>
                            </div>
                            <div className="right-column">
                                <img src={item.gallery[0]} alt={item.name} className="cart-image" />
                            </div>
                        </div>
                    ))}
                    <div className='cart-summary'>
                        <span>Total</span>
                        <span>${totalCost.toFixed(2)}</span>
                    </div>
                    <button
                        className={items.length === 0 ? 'disabled-order-btn' : 'place-order-btn'}
                        disabled={items.length === 0}
                        onClick={handleOrderButton}>
                        Place Order
                    </button>
                </div>
            </div>
        )
    }
}

export default CartOverlay
