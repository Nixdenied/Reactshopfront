import React, { Component } from 'react'
import './Header.css'

/**
 * Header component for displaying a header text.
 */

class Header extends Component {
  render() {
    const { header } = this.props

    /**
     * Renders the Header component.
     *
     * This method renders the header text passed as a prop.
     *
     * @returns {React.Element} The rendered component.
     */

    return (
      <>
        <div className="header">{header}</div>
      </>
    )
  }
}

export default Header
