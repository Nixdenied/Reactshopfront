import { gql } from '@apollo/client'

export const CREATE_ORDER_MUTATION = gql`
  mutation CreateOrders($orders: [Orders]!) {
    createOrders(orders: $orders) { 
        order_id status message 
    }
  }
`
