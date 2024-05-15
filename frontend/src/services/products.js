import { ALL_PRODUCTS, PRODUCT_BY_ID } from '../graphql/queries'
import { ApolloClient, InMemoryCache } from '@apollo/client'

class Product {

  /**
   * Constructs the Product class.
   *
   * This constructor initializes the ApolloClient with the given URI
   * and sets up the cache with type policies.
   *
   * @param {string} uri - The URI of the GraphQL endpoint.
   */

  constructor(uri) {
    this.client = new ApolloClient({
      uri: uri,
      cache: new InMemoryCache({
        typePolicies: {
          Attributes: {
            keyFields: false,
          },
        },
      }),
    })
  }

  /**
   * Fetches all products.
   *
   * This method executes the ALL_PRODUCTS GraphQL query to fetch all products.
   *
   * @async
   * @returns {Object|null} The data from the query, or null if an error occurs.
   */

  async fetchAllProducts() {
    const query = ALL_PRODUCTS
    try {
      const { data } = await this.client.query({ query })
      return data
    } catch (error) {
      return null
    }
  }

  /**
   * Fetches a product by its ID.
   *
   * This method executes the PRODUCT_BY_ID GraphQL query to fetch a product by its ID.
   *
   * @async
   * @param {string} id - The ID of the product to fetch.
   * @returns {Object} The product data.
   * @throws {Error} Throws an error if the query fails.
   */

  async fetchProduct(id) {
    const query = PRODUCT_BY_ID
    try {
      const { data } = await this.client.query({
        query: query,
        variables: { id },
      })
      return data.product
    } catch (error) {
      throw new Error(error)
    }
  }
}

export default Product
