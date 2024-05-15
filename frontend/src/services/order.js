import { CREATE_ORDER_MUTATION } from '../graphql/mutation'
import { ApolloClient, InMemoryCache } from '@apollo/client'

class Order {

  /**
   * Constructs the Order class.
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
   * Creates a new order.
   *
   * This method executes the CREATE_ORDER_MUTATION GraphQL mutation
   * to create a new order with the given variables.
   *
   * @async
   * @param {Object} variables - The variables for the mutation, including order details.
   * @returns {Object} The data returned from the mutation.
   * @throws {Error} Throws an error if the mutation fails.
   */

  async createOrder(variables) {
    const mutation = CREATE_ORDER_MUTATION
    try {
      const { data } = await this.client.mutate({
        mutation: mutation,
        variables: variables,
      })
      return data
    } catch (error) {
      throw new Error('Error details:', error.message)
    }
  }
}


export default Order
