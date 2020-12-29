**API development**
(for authentication using LARAVEL PASSPORT)

**Register an user (Postman)**
http://localhost:8000/api/register
*Body(form-data)*

name:artur
login:mikki
cell_phone:89061211957
is_legal_person:1
password:12345

---

**Login**
http://localhost:8000/api/login
*Body(form-data)*

login:mikki
password:12345

---

**User details**
http://localhost:8000/api/user/details
*Headers*

Authorization:Bearer point_your_token
Content-Type:application/x-www-form-urlencoded
Accept:application/json

---

**Create an Order**
http://localhost:8000/api/order/create
*Headers*

Authorization:Bearer point_your_token
Content-Type:application/x-www-form-urlencoded
Accept:application/json

*Body(form-data)*

name:make a test
description:as soon as possible
mediator_percent:50
execute_at:2021-10-10

---

**Mark as completed an order**
http://localhost:8000/api/order/1/completed
*Headers*

Authorization:Bearer point_your_token
Content-Type:application/x-www-form-urlencoded
Accept:application/json

---

**Cancel an order**
http://localhost:8000/api/order/1/cancel
*Headers*

Authorization:Bearer point_your_token
Content-Type:application/x-www-form-urlencoded
Accept:application/json

---

**Get an order by id**
http://localhost:8000/api/order/1
*Headers*

Authorization:Bearer point_your_token
Content-Type:application/x-www-form-urlencoded
Accept:application/json

---

**Get list orders**
http://localhost:8000/api/order/list
*Headers*

Authorization:Bearer point_your_token
Content-Type:application/x-www-form-urlencoded
Accept:application/json

---

**Create an application by order**
http://localhost:8000/api/application/create/by-order-id/1
*Headers*

Authorization:Bearer point_your_token
Content-Type:application/x-www-form-urlencoded
Accept:application/json

---

**Accept an application**
http://localhost:8000/api/application/accept/1
*Headers*

Authorization:Bearer point_your_token
Content-Type:application/x-www-form-urlencoded
Accept:application/json

---