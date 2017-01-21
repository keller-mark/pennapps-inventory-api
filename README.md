# PennApps w2017 Inventory API

### Endpoints

##### API Welcome
```
GET /api
```

##### List Inventory
```
GET /api/inventory
```

##### Checkout Items
```
POST /api/checkout/<account_id>
```
Parameters:

| Key | Value |
| ------------ | ------------- |
| `items` | `[{"id": 4, "quantity": 5},{"id": 2, "quantity": 6}]` |

##### Restock Items
```
POST /api/restock
```
Parameters:

| Key | Value |
| ------------ | ------------- |
| `items` | `[{"id": 4, "quantity": 5},{"id": 2, "quantity": 6}]` |

##### Merchant Info
```
GET /api/merchant_info
```

##### List Customers
```
GET /api/customers
```

##### Find a Customer
```
GET /api/customers/<customer_id>
```
