/// <reference path="../typings/index.d.ts" />

import {Application} from "~express/lib/application";
import router = require('./router');
import {Request} from "~express/lib/request";
import {Response} from "~express/lib/response";

export class Api {
    constructor(private app:Application, private port:number) {
        app.use('/', router);
    }

    public run() {
        this.app.listen(this.port);
    }
}