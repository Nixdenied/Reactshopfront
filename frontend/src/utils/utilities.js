/**
 * Calculates the total price of items in the cart.
 *
 * This function takes an array of items and calculates the total price by
 * multiplying the price of each item by its quantity and summing up the results.
 *
 * @param {Array} items - The array of items in the cart.
 * @returns {number} The total price of the items.
 */

export const calculateTotal = (items) => {
  return items.reduce((acc, item) => acc + item.prices[0].amount * item.quantity, 0)
}

/**
 * Calculates the total quantity of items in the cart.
 *
 * This function takes an array of items and calculates the total quantity by
 * summing up the quantity of each item.
 *
 * @param {Array} items - The array of items in the cart.
 * @returns {number} The total quantity of the items.
 */

export const calculateTotalItems = (items) => {
  return items.reduce((total, item) => total + item.quantity, 0)
}

/**
 * Maps cart items to order items format.
 *
 * This function takes an array of cart items and maps them to the format required
 * for creating an order. It extracts selected options for each item and includes
 * them in the order items.
 *
 * @param {Array} cartItems - The array of items in the cart.
 * @returns {Array} The array of order items.
 */

export const mapOrderItems = (cartItems) => {
  return cartItems.map(item => {
    const selectedOptions = item.attributes.flatMap(attr =>
      attr.items.filter(attrItem => item.selectedOptions[attr.name] === attrItem.value)
        .map(attrItem => ({
          attribute_name: attr.name,
          attribute_value: attrItem.displayValue,
        })),
    )

    return {
      product_id: item.id,
      quantity: item.quantity,
      order_selected_options: selectedOptions,
    }
  })
}

/**
 * Extracts the currency label from the cart items.
 *
 * This function takes an array of cart items and extracts the currency label
 * from the first item's prices. If no currency label is found, it defaults to 'USD'.
 *
 * @param {Array} cartItems - The array of items in the cart.
 * @returns {string} The currency label.
 */

export const extractCurrency = (cartItems) => {
  return cartItems[0]?.prices[0]?.currency.label || 'USD'
}