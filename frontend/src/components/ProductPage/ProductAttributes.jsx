import React, { Component } from 'react'
import './ProductAttributes.css'

/**
 * ProductAttributes component for displaying product attribute selection.
 */

class ProductAttributes extends Component {

  /**
   * Constructs the ProductAttributes component.
   *
   * This constructor initializes the state with selected attributes.
   *
   * @param {Object} props - The properties passed to the component.
   */

  constructor(props) {
    super(props)
    this.state = {
      selectedAttributes: {},
    }
  }

  /**
   * Handles the selection of an attribute.
   *
   * This method updates the state with the selected attribute value and
   * triggers the onSelectAttribute function passed in as a prop.
   *
   * @param {string} attrName - The name of the attribute.
   * @param {string} value - The selected value of the attribute.
   */

  selectAttribute = (attrName, value) => {
    this.setState(prevState => ({
      selectedAttributes: {
        ...prevState.selectedAttributes,
        [attrName]: value,
      },
    }))
    this.props.onSelectAttribute(attrName, value)
  }

  /**
   * Renders the ProductAttributes component.
   *
   * This method renders the attribute selection buttons for each attribute of the product.
   *
   * @returns {React.Element} The rendered component.
   */

  render() {
    const { attributes } = this.props
    const { selectedAttributes } = this.state

    return (
      <div className='attribute-container'>
        {attributes.map(attribute => (
          <div key={attribute.id}>
            <div className='product-text-header'>{attribute.name}:</div>
            <div>
              {attribute.items.map(item => (
                <button
                  key={item.id}
                  onClick={() => this.selectAttribute(attribute.name, item.value)}
                  className={`attribute-button ${selectedAttributes[attribute.name] === item.value ? 'attribute-button-clicked' : ''}`}
                  style={{ backgroundColor: item.value }}
                >
                  {attribute.type === 'swatch' ? <div style={{ backgroundColor: item.value }} /> : item.value}
                </button>
              ))}
            </div>
          </div>
        ))}
      </div>
    )
  }
}

export default ProductAttributes
