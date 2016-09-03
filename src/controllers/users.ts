/// <reference path="../../typings/index.d.ts" />

import {Request} from "~express/lib/request";
import {Response} from "~express/lib/response";
import {Logger} from "bunyan";

export class User {
    public get(request:Request, response:Response) {
        response.send('Help Me Abstract :: User get');
    }

    public create(request:Request, response:Response) {
        response.send('Help Me Abstract :: User create');
    }

    public update(request:Request, response:Response) {
        response.send('Help Me Abstract :: User update');
    }

    public delete(request:Request, response:Response) {
        response.send('Help Me Abstract :: User delete');
    }

    public list(request:Request, response:Response) {
        response.send('Help Me Abstract :: User List');
    }
}