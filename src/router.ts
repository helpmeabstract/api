/// <reference path="../typings/index.d.ts" />

import express = require("express");
import {Request} from "~express/lib/request";
import {Response} from "~express/lib/response";
import {User} from "./controllers/users";

let router = express.Router();
let user_controller = new User;

router.get('/', function(request: Request, response: Response){
    response.send("Help Me Abstract API");
});

router.route('/users')
    .get(user_controller.list)
    .post(user_controller.create)
;

router.route('/users/:id')
    .get(user_controller.get)
    .put(user_controller.update)
    .delete(user_controller.delete)
;

export = router;
