import {Validation} from "./Validation.js";

interface Validator{
    required?: boolean;
    minLength?: number;
    maxLength?: number;
    min?: number;
    max?: number;
    pattern?: string;
    email?: boolean;
    url?: boolean;
}

export class VenteFormHandler {
    private formElement: HTMLFormElement;

    constructor(formSelector: string) {
        this.formElement = document.querySelector(formSelector) as HTMLFormElement;
        if (!this.formElement) {
            throw new Error('Form not found');
        }
    }
    // : Record<string, any>
    getFormData(){
        const formData = new FormData(this.formElement);
        const montantTotal = document.getElementById("montantTotal") as HTMLInputElement;
        // console.log(formData);
        const data: Record<string, any> = {};
        formData.forEach((value, key) => {
            const match = key.match(/articles\[(\d+)\]\[(\w+)\]/);
            if (!match) data[key] = value;
        });
        const articles: any[] = [];
        formData.forEach((value, key) => {
            const match = key.match(/articles\[(\d+)\]\[(\w+)\]/);
            if (match) {
                const index = parseInt(match[1], 10);
                const field = match[2];
                if (!articles[index]) {
                    articles[index] = {};
                }
                articles[index][field] = value;
            }
        });
        data["articles"] = [];
        articles.forEach((value,key) => {
            data["articles"][key] = value;
        })
        data["montantTotal"] = montantTotal.value;
        data["formulaire"] = "vente-add";
        return data;
    }

    resetForm(): void {
        this.formElement.reset();
    }

    validateForm(): boolean {
        const inputs = this.formElement.querySelectorAll('input, textarea, select') as NodeListOf<HTMLInputElement>;
        // return Validation.checkRequireGlobal3(inputs);
        return true;
    }
    handleSubmit(callback: (data: Record<string, any>) => void): void {
        this.formElement.addEventListener('submit', (event: Event) => {
            event.preventDefault();
            if (this.validateForm()) {
                const dataFirst = this.getFormData();
                callback(dataFirst);
            }else {
                console.log("Error");
            }
        });
    }
}
