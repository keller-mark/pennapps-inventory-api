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
POST /api/checkout
```
Parameters:
| Key | Value |
| ------------ | ------------- |
| `items` | `[{"id": 4, "quantity": 5},{"id": 2, "quantity": 6}]` |
