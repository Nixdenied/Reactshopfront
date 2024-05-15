import React, { Component } from 'react'
import './ImageCarousel.css'

/**
 * ImageCarousel component for displaying a carousel of product images.
 */

class ImageCarousel extends Component {

  /**
   * Constructs the ImageCarousel component.
   *
   * This constructor initializes the state with the selected index.
   *
   * @param {Object} props - The properties passed to the component.
   */

  constructor(props) {
    super(props)
    this.state = {
      selectedIndex: 0,
    }
  }

  /**
   * Lifecycle method called after the component is mounted.
   *
   * This method sets the initial selected index based on the selected image.
   */

  componentDidMount() {
    const { gallery, selectedImage } = this.props
    const selectedIndex = gallery.indexOf(selectedImage)
    this.setState({ selectedIndex })
  }

  /**
   * Handles the next button click event.
   *
   * This method updates the state to show the next image in the gallery.
   */

  handleNext = () => {
    const { gallery } = this.props
    this.setState(prevState => ({
      selectedIndex: (prevState.selectedIndex + 1) % gallery.length,
    }), () => {
      this.props.onImageSelect(gallery[this.state.selectedIndex])
    })
  }

  /**
   * Handles the previous button click event.
   *
   * This method updates the state to show the previous image in the gallery.
   */

  handlePrevious = () => {
    const { gallery } = this.props
    this.setState(prevState => ({
      selectedIndex: (prevState.selectedIndex - 1 + gallery.length) % gallery.length,
    }), () => {
      this.props.onImageSelect(gallery[this.state.selectedIndex])
    })
  }

  /**
   * Renders the ImageCarousel component.
   *
   * This method renders the image thumbnails and the main selected image
   * with navigation buttons for cycling through the images.
   *
   * @returns {React.Element} The rendered component.
   */

  render() {
    const { gallery, selectedImage, onImageSelect } = this.props
    return (
      <div className="image-gallery">
        <div className="thumbnail-container">
          {gallery.map((image, index) => (
            <img
              key={index}
              src={image}
              alt={`Thumbnail ${index}`}
              className={`thumbnail ${selectedImage === image ? 'selected' : ''}`}
              onClick={() => onImageSelect(image)}
            />
          ))}
        </div>
        <div className='main-image-container'>
          <button className='main-image-btns-left' onClick={this.handleNext}>
            <span className="material-icons">
              arrow_back
            </span>
          </button>
          <img src={selectedImage} alt="Main Product" className="main-image" />
          <button className='main-image-btns-right' onClick={this.handlePrevious}>
            <span className="material-icons">
              arrow_forward
            </span>
          </button>
        </div>
      </div>
    )
  }
}

export default ImageCarousel
