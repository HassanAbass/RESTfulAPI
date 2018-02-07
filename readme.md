

## About restful
[**restful**](http://resttfull.herokuapp.com) is simple  that is based on laravel framework, using postgresql database .

**- Authorization using Oauth2
- Cover all the resource relations**


## Methods
To access the application you need to get acquire 
Personal Access Token through the  interface with specifying the proper
scope Or get client secret key


<pre> 
+-----------+------------------------------------------------+------------------
| Method    | URI                                            | Middleware       
+-----------+------------------------------------------------+------------------
| GET|HEAD  | /                                              |
| GET|HEAD  | buyers                                         |
| GET|HEAD  | buyers/{buyer}                                 |
| GET|HEAD  | buyers/{buyer}/categories                      |
| GET|HEAD  | buyers/{buyer}/products                        |
| GET|HEAD  | buyers/{buyer}/sellers                         |
| GET|HEAD  | buyers/{buyer}/transactions                    |
| POST      | categories                                     |
| GET|HEAD  | categories                                     |
| DELETE    | categories/{category}                          |
| PUT|PATCH | categories/{category}                          |
| GET|HEAD  | categories/{category}                          |
| GET|HEAD  | categories/{category}/buyers                   |
| GET|HEAD  | categories/{category}/products                 |
| GET|HEAD  | categories/{category}/sellers                  |
| GET|HEAD  | categories/{category}/transactions             |
| GET|HEAD  | home                                           |
| GET|HEAD  | home/authorized-clients                        |
| GET|HEAD  | home/my-clients                                |
| GET|HEAD  | home/my-tokens                                 |
| POST      | login                                          |
| GET|HEAD  | login                                          |
| POST      | logout                                         |
| POST      | oauth/authorize                                |
| DELETE    | oauth/authorize                                |
| GET|HEAD  | oauth/authorize                                |
| POST      | oauth/clients                                  |
| GET|HEAD  | oauth/clients                                  |
| DELETE    | oauth/clients/{client_id}                      |
| PUT       | oauth/clients/{client_id}                      |
| POST      | oauth/personal-access-tokens                   |
| GET|HEAD  | oauth/personal-access-tokens                   |
| DELETE    | oauth/personal-access-tokens/{token_id}        |
| GET|HEAD  | oauth/scopes                                   |
| POST      | oauth/token                                    |
| POST      | oauth/token/refresh                            |
| GET|HEAD  | oauth/tokens                                   |
| DELETE    | oauth/tokens/{token_id}                        |
| POST      | password/email                                 |
| POST      | password/reset                                 |
| GET|HEAD  | password/reset                                 |
| GET|HEAD  | password/reset/{token}                         |
| GET|HEAD  | products                                       |
| GET|HEAD  | products/{product}                             |
| GET|HEAD  | products/{product}/buyers                      |
| POST      | products/{product}/buyers/{buyer}/transactions | purchase_product 
| POST      | products/{product}/categories                  | manage_products  
| GET|HEAD  | products/{product}/categories                  |
| PUT|PATCH | products/{product}/categories/{category}       | manage_products  
| DELETE    | products/{product}/categories/{category}       | manage_products
| GET|HEAD  | products/{product}/transactions                |
| GET|HEAD  | sellers                                        |
| GET|HEAD  | sellers/{seller}                               |
| GET|HEAD  | sellers/{seller}/buyers                        |
| GET|HEAD  | sellers/{seller}/categories                    |
| GET|HEAD  | sellers/{seller}/products                      | manage_products
| POST      | sellers/{seller}/products                      | manage_products
| DELETE    | sellers/{seller}/products/{product}            | manage_products
| PUT|PATCH | sellers/{seller}/products/{product}            | manage_products
| GET|HEAD  | sellers/{seller}/transactions                  |
| GET|HEAD  | transactions                                   |
| GET|HEAD  | transactions/{transaction}                     |
| GET|HEAD  | transactions/{transaction}/categories          |
| GET|HEAD  | transactions/{transaction}/sellers             |
| GET|HEAD  | users                                          |
| POST      | users                                          |
| GET|HEAD  | users/verify/{token}                           |
| DELETE    | users/{user}                                   |
| PUT|PATCH | users/{user}                                   | manage_accounts
| GET|HEAD  | users/{user}                                   | manage_accounts
| GET|HEAD  | users/{user}/resend                            |
+-----------+------------------------------------------------+-----------------
