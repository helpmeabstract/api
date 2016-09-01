/// <reference path="../typings/index.d.ts" />

import express = require('express');
import { Api } from './app';

// Configuration
let port = process.env.LISTEN_PORT || 8080;

let api = new Api(express(), port);
api.run();

console.info(`listening on ${port}`);