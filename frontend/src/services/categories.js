import { ALL_CATEGORIES } from '../graphql/queries'
import { ApolloClient, InMemoryCache } from '@apollo/client'

class Categories {

  /**
   * Constructs the Categories class.
   *
   * This constructor initializes the ApolloClient with the given URI
   * and sets up the cache.
   *
   * @param {string} uri - The URI of the GraphQL endpoint.
   */

  constructor(uri) {
    this.client = new ApolloClient({
      uri: uri,
      cache: new InMemoryCache(),
    })
  }

  /**
   * Fetches all categories for use on Header and NavBar.
   *
   * This method executes the ALL_CATEGORIES GraphQL query to fetch all categories.
   *
   * @async
   * @returns {Object|null} The data from the query, or null if an error occurs.
   */

  async fetchAllCategories() {
    const query = ALL_CATEGORIES
    try {
      const { data } = await this.client.query({ query })
      return data
    } catch (error) {
      return null
    }
  }
}


export default Categories
