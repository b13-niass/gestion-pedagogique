import {DAO} from "./DAO.js";

export class DbQuery{
    private dao: DAO;
    constructor(private DB: any) {
        this.dao = new DAO();
    }

    setDB(DB: any){
        this.DB = DB;
    }

}