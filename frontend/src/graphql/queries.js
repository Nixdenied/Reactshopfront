import { gql } from '@apollo/client'

//'{"query": "query { allCategories { name } }"}' 

export const ALL_CATEGORIES = gql`
    query allCategories {
      categories: allCategories {
        name
      }
    }
`

export const ALL_PRODUCTS = gql`
    query allProducts {
        products: allProducts { 
            index: id
            name 
            id: external_id 
            inStock
            gallery
            description 
            category 
            prices {
                amount
                currency {
                    label
                    symbol
                }
            }
            brand 
            attributes { 
                id: external_id
                name 
                type 
                items { 
                    displayValue 
                    value 
                    id: external_id 
                } 
            }
        }
    }
`

export const PRODUCT_BY_ID = gql`
query Product($id: String!) {
  product(id: $id) {
    index: id
    name
    id: external_id
    inStock
    gallery
    description
    category
    prices {
      amount
      currency {
        label
        symbol
      }
    }
    brand
    attributes {
      id: external_id
      name
      type
      items {
        displayValue
        value
        id: external_id
      }
    }
  }
}
`
