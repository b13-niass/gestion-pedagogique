import {} from "../Interface/DataBinding.js";

export class DAO{
    private url: string;

    constructor(init?: Partial<DAO>) {
        Object.assign(this, init);
        this.url = "http://www.cheikh.ibrahima.dieng:8124";
    }

    setUrl(url: string){
        this.url = url;
    }

    private buildQueryParams(params: Record<string, any>): string {
        const queryParams = new URLSearchParams();
        for (const key in params) {
            if (params.hasOwnProperty(key)) {
                queryParams.append(key, params[key]);
            }
        }
        return queryParams.toString();
    }


    getData(uri: string): Promise<any>{
        // const queryString = params ? `?${this.buildQueryParams(params)}` : '';
        return fetch(`${this.url}/${uri}`, {
                method: 'GET',
        }).then(response =>  response.json()).catch(error => error);
    }

    postData(uri:string, db: any):Promise<any>{
        return fetch(`${this.url}/${uri}`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(db)
        }).then( response => response.json()).catch(error => error);
    }

}