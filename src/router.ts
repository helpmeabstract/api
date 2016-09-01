import express = require("express");
import {Request} from "~express/lib/request";
import {Response} from "~express/lib/response";

let router = express.Router();

router.get('/', (request: Request, response: Response) => {
    response.send("Help me abstract!");
});

export = router;
