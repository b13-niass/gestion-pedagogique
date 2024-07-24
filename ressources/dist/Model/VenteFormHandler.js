export class VenteFormHandler {
    formElement;
    constructor(formSelector) {
        this.formElement = document.querySelector(formSelector);
        if (!this.formElement) {
            throw new Error('Form not found');
        }
    }
    // : Record<string, any>
    getFormData() {
        const formData = new FormData(this.formElement);
        const montantTotal = document.getElementById("montantTotal");
        // console.log(formData);
        const data = {};
        formData.forEach((value, key) => {
            const match = key.match(/articles\[(\d+)\]\[(\w+)\]/);
            if (!match)
                data[key] = value;
        });
        const articles = [];
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
        articles.forEach((value, key) => {
            data["articles"][key] = value;
        });
        data["montantTotal"] = montantTotal.value;
        data["formulaire"] = "vente-add";
        return data;
    }
    resetForm() {
        this.formElement.reset();
    }
    validateForm() {
        const inputs = this.formElement.querySelectorAll('input, textarea, select');
        // return Validation.checkRequireGlobal3(inputs);
        return true;
    }
    handleSubmit(callback) {
        this.formElement.addEventListener('submit', (event) => {
            event.preventDefault();
            if (this.validateForm()) {
                const dataFirst = this.getFormData();
                callback(dataFirst);
            }
            else {
                console.log("Error");
            }
        });
    }
}
