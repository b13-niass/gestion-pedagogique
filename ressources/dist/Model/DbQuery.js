import { DAO } from "./DAO.js";
export class DbQuery {
    DB;
    dao;
    constructor(DB) {
        this.DB = DB;
        this.dao = new DAO();
    }
    setDB(DB) {
        this.DB = DB;
    }
}
