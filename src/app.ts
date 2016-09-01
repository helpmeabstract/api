import {Application} from "~express/lib/application";
import router = require('./router');

export class Api {
    constructor(private app:Application, private port:number) {
        app.use('/', router);
    }

    public run() {
        this.app.listen(this.port);
    }
}