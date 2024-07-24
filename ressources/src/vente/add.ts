// import {DAO} from "../Model/DAO.js";
// import {IAddVenteLoadData, IClient, IDetteListe} from "../Interface/DataBinding.js";
// import {VenteFormHandler} from "../Model/VenteFormHandler.js";
//
// (async () => {
//     const preloaderId = document.getElementById("preloaderId") as HTMLInputElement;
//
//     /** Variable Declaration **/
//     const dao: DAO = new DAO();
//     const venteLoadData: IAddVenteLoadData = await dao.getData("api/loadpage/vente-add");
//     console.log(venteLoadData);
//     const venteFormHandler: VenteFormHandler = new VenteFormHandler("#formAddVente");
//     const telephoneEl: HTMLInputElement = document.getElementById("telephone") as HTMLInputElement;
//     const typeClientEl: HTMLInputElement = document.getElementById("typeClient") as HTMLInputElement;
//     const detteIdCheckEl: HTMLInputElement = document.getElementById("detteIdCheck") as HTMLInputElement;
//     const detteIdEl: HTMLInputElement = document.getElementById("detteId") as HTMLInputElement;
//     const basicCollapseOne: HTMLInputElement = document.getElementById("basicCollapseOne") as HTMLInputElement;
//     const addligneproduit = document.getElementById("addligneproduit") as HTMLButtonElement;
//     const montantTotal = document.getElementById("montantTotal") as HTMLInputElement;
//
//     let clientFound: number = 0;
//     let nbrLignProduit:number = 0;
//
//     /** Function Declaration **/
//
//     const onDataLigneArticle = () => {
//         const dataLignearticles = document.querySelectorAll("[data-lignearticlebutton]") as NodeListOf<HTMLButtonElement>;
//
//         dataLignearticles.forEach((dtL: HTMLButtonElement) => {
//             dtL.addEventListener("click", (event: Event) => {
//                 (dtL.parentElement as HTMLDivElement).remove();
//                 if (nbrLignProduit >= 1 ){
//                     nbrLignProduit = nbrLignProduit - 1;
//                 }
//             })
//         })
//     }
//
//     const templateLigneArticle = () => {
//         ++nbrLignProduit;
//         return `
//         <div data-montant${nbrLignProduit}="0" class="montantLigne p-[10px] bg-primary/10 border-solid border-b border-primary relative">
//             <h1 class="mb-0 inline-flex items-center py-[6px] overflow-hidden whitespace-nowrap text-ellipsis text-[15px] font-semibold text-dark dark:text-title-dark capitalize">
//                 Article ${nbrLignProduit+1}
//             </h1>
//             <button type="button" data-lignearticlebutton="${nbrLignProduit}" id="lignearticle" class="absolute right-0 top-0 capitalize bg-danger hover:bg-danger-hbr border-solid border-1 border-danger text-white dark:text-title-dark text-[14px] font-semibold leading-[22px] inline-flex items-center justify-center rounded-[40px] px-[5px] h-[20px] w-[20px] transition duration-300 ease-in-out">X</button>
//             <div class="sm:grid sm:grid-cols-12 max-sm:flex max-sm:flex-col gap-[25px]">
//                 <div class="col-span-12 xl:col-span-2">
//                     <label for="categorie-${nbrLignProduit}" class="inline-flex items-center w-[178px] mb-2 text-sm font-medium capitalize text-dark dark:text-title-dark">Catégorie</label>
//                     <select id="categorie-${nbrLignProduit}" name="articles[${nbrLignProduit}][categorie]" class="py-[11px] px-[20px] w-full capitalize text-body dark:text-white border-regular dark:border-box-dark-up border-1 rounded-6 dark:bg-box-dark-up outline-none mb-[20px]">
//                         <option value="" selected>Catégorie</option>
//                     </select>
//                     <span class="error-message text-[0.8rem]">error</span>
//                 </div>
//                 <div class="content col-span-12 xl:col-span-3">
//                     <label for="article-${nbrLignProduit}" class="inline-flex items-center w-[178px] mb-2 text-sm font-medium capitalize text-dark dark:text-title-dark">Article</label>
//                     <select name="articles[${nbrLignProduit}][article]" id="article-${nbrLignProduit}" class="py-[11px] px-[20px] w-full capitalize text-body dark:text-white border-regular dark:border-box-dark-up border-1 rounded-6 dark:bg-box-dark-up outline-none mb-[20px]">
//                     <option value="" selected>Article</option>
//                     </select>
//                     <span class="error-message text-[0.8rem]">error</span>
//                 </div>
//                 <div class="col-span-12 xl:col-span-2">
//                     <label for="quantite-${nbrLignProduit}" class="inline-flex items-center w-[178px] mb-2 text-sm font-medium capitalize text-dark dark:text-title-dark">Quantité</label>
//                     <input type="text" name="articles[${nbrLignProduit}][quantite]" id="quantite-${nbrLignProduit}" class="rounded-4 border-normal border-1 text-[15px] dark:bg-box-dark-up dark:border-box-dark-up px-[20px] py-[12px] min-h-[50px] outline-none placeholder:text-[#A0A0A0] text-body dark:text-subtitle-dark w-full focus:ring-primary focus:border-primary" placeholder="quantité" autocomplete="off">
//                 </div>
//                 <div class="col-span-12 xl:col-span-2">
//                     <label for="unite-${nbrLignProduit}" class="inline-flex items-center w-[178px] mb-2 text-sm font-medium capitalize text-dark dark:text-title-dark">Unité</label>
//                     <select name="articles[${nbrLignProduit}][unite]" id="unite-${nbrLignProduit}" class="py-[11px] px-[20px] w-full capitalize text-body dark:text-white border-regular dark:border-box-dark-up border-1 rounded-6 dark:bg-box-dark-up outline-none mb-[20px]">
//                         <option value="" selected>Unité</option>
//                     </select>
//                 </div>
//                 <div class="col-span-12 xl:col-span-3">
//                     <label for="prixUnitaire-${nbrLignProduit}" class="inline-flex items-center w-[178px] mb-2 text-sm font-medium capitalize text-dark dark:text-title-dark">Prix Unitaire</label>
//                     <input type="text" name="articles[${nbrLignProduit}][prixUnitaire]" id="prixUnitaire-${nbrLignProduit}" class="rounded-4 border-normal border-1 text-[15px] dark:bg-box-dark-up dark:border-box-dark-up px-[20px] py-[12px] min-h-[50px] outline-none placeholder:text-[#A0A0A0] text-body dark:text-subtitle-dark w-full focus:ring-primary focus:border-primary" placeholder="prix unitaire" autocomplete="off">
//                 </div>
//             </div>
//             </div>
//         `;
//     }
//
//     const calculMontantTotal = () => {
//         const montantLignes = document.querySelectorAll(".montantLigne") as NodeListOf<HTMLDivElement>;
//         let total = 0;
//
//         montantLignes.forEach((div) => {
//             for (let key in div.dataset) {
//                 if (key.startsWith("montant")) {
//                     total += Number(div.dataset[key]);
//                 }
//             }
//         });
//
//         montantTotal.value = total.toString();
//     };
//
//     const buildLigneProduit = () => {
//         basicCollapseOne.insertAdjacentHTML("afterbegin", templateLigneArticle());
//     }
//
//     const disableOrEnableClientInputs = () => {
//         const clientInputs: NodeListOf<HTMLInputElement> = document.querySelectorAll(".clientInfo");
//         clientInputs.forEach((input) => {
//             if (input.name != "telephone") {
//                 input.disabled = clientFound === 1;
//             }
//         });
//     }
//
//     const clientInputsValues = (client:IClient) => {
//         const clientInputs: NodeListOf<HTMLInputElement> = document.querySelectorAll(".clientInfo");
//         clientInputs.forEach((input) => {
//             const value = client[input.name as keyof IClient]! + "";
//             input.value = value;
//         });
//     }
//
//     const clientInputsValuesClear = () => {
//         const clientInputs: NodeListOf<HTMLInputElement> = document.querySelectorAll(".clientInfo");
//         clientInputs.forEach((input) => {
//             if (input.name != "telephone") {
//                 input.value = "";
//             }
//         });
//     }
//
//     const loadCategorieOptions = (categorieId:number) => {
//         const categorieEl = document.getElementById(`categorie-${categorieId}`) as HTMLSelectElement;
//         venteLoadData.categories?.forEach(categorie =>{
//             const opt = document.createElement('option');
//             opt.value = categorie.id!+"";
//             opt.textContent = categorie.libelle!;
//             categorieEl.appendChild(opt);
//         })
//     }
//
//     const onChangeCategories = (categorieId:number) => {
//         const categorieEl = document.getElementById(`categorie-${categorieId}`) as HTMLSelectElement;
//         const articlesEl = document.getElementById(`article-${categorieId}`) as HTMLSelectElement;
//         const unitesEl = document.getElementById(`unite-${categorieId}`) as HTMLSelectElement;
//         const prixEl = document.getElementById(`prixUnitaire-${categorieId}`) as HTMLInputElement;
//         const quantiteEl = document.getElementById(`quantite-${categorieId}`) as HTMLInputElement;
//         const parentLigne = document.querySelector(`[data-montant${categorieId}]`) as HTMLDivElement;
//         // console.log(parentLigne);
//         categorieEl.addEventListener("change", (event) =>{
//             articlesEl.innerHTML = `<option selected>Article</option>`;
//             venteLoadData.articles?.forEach(a =>{
//                 if(a.categorie_id == parseInt(categorieEl.value)){
//                     const opt = document.createElement('option');
//                     opt.value = a.id!+"";
//                     opt.textContent = a.libelle!;
//                     articlesEl.appendChild(opt);
//                 }
//             })
//         });
//
//         articlesEl.addEventListener("change", (event) =>{
//             unitesEl.innerHTML = `<option selected>Unité</option>`;
//             venteLoadData.article_unites?.forEach(au =>{
//                 if(au.article_id == parseInt(articlesEl.value)){
//                     const opt = document.createElement('option');
//                     opt.value = au.id!+"";
//                     opt.textContent = au.libelle!;
//                     unitesEl.appendChild(opt);
//                 }
//             })
//         });
//
//         unitesEl.addEventListener("change", (event)=>{
//             venteLoadData.stocks?.forEach(stock => {
//                 if (parseInt(articlesEl.value) == stock.article_id) {
//                     if (unitesEl.options[unitesEl.selectedIndex].text == "Box") {
//                         prixEl.value = stock.prix_boite+"";
//                     }
//                     if (unitesEl.options[unitesEl.selectedIndex].text == "Pièces") {
//                         prixEl.value = stock.prix_unitaire+"";
//                     }
//                     if (!isNaN(parseInt(quantiteEl.value)) && !isNaN(parseInt(prixEl.value))){
//                         const montant = parseInt(quantiteEl.value) * parseInt(prixEl.value);
//                         parentLigne.dataset[`montant${categorieId}`] = montant+"";
//                         calculMontantTotal();
//                     }else{
//                         parentLigne.dataset[`montant${categorieId}`] = "0";
//                         calculMontantTotal();
//                     }
//                 }
//             })
//         });
//
//         quantiteEl.addEventListener("input", (event) => {
//             if (!isNaN(parseInt(quantiteEl.value)) && !isNaN(parseInt(prixEl.value))){
//                 const montant = parseInt(quantiteEl.value) * parseInt(prixEl.value);
//                 parentLigne.dataset[`montant${categorieId}`] = montant+"";
//                 calculMontantTotal();
//             }else{
//                 parentLigne.dataset[`montant${categorieId}`] = "0";
//                 calculMontantTotal();
//             }
//         })
//         prixEl.addEventListener("input", (event) => {
//             if (!isNaN(parseInt(quantiteEl.value)) && !isNaN(parseInt(prixEl.value))){
//                 const montant = parseInt(quantiteEl.value) * parseInt(prixEl.value);
//                 parentLigne.dataset[`montant${categorieId}`] = montant+"";
//                 calculMontantTotal();
//             }else{
//                 parentLigne.dataset[`montant${categorieId}`] = "0";
//                 calculMontantTotal();
//             }
//         })
//     }
//
//     /** Initialisation **/
//     preloaderId.classList.add("hidden");
//     loadCategorieOptions(0);
//     onChangeCategories(0);
//     detteIdEl.disabled = true;
//
//     /** Event Declaration **/
//     telephoneEl.addEventListener("input", (event: Event)=>{
//         if (telephoneEl.value.length >= 8){
//             const client : IClient|undefined = venteLoadData.clients?.find(c => c.telephone == telephoneEl.value);
//             if (client!==undefined){
//                 clientFound = 1;
//                 clientInputsValues(client);
//                 disableOrEnableClientInputs();
//             }else {
//                 clientFound = 0;
//                 clientInputsValuesClear();
//                 disableOrEnableClientInputs();
//             }
//         }
//     });
//     typeClientEl.addEventListener("click", (event) => {
//         console.log(typeClientEl.checked)
//         if(typeClientEl.checked){
//             clientFound = 1;
//             clientInputsValuesClear();
//             disableOrEnableClientInputs();
//             telephoneEl.value = "";
//             telephoneEl.disabled = true;
//         }else{
//             clientFound = 0;
//             disableOrEnableClientInputs();
//             telephoneEl.disabled = false;
//         }
//     });
//     detteIdCheckEl.addEventListener("click", (event) => {
//         if(detteIdCheckEl.checked){
//             detteIdEl.disabled = false;
//         }else{
//             detteIdEl.disabled = true;
//             detteIdEl.value = "";
//         }
//     });
//
//     addligneproduit.addEventListener("click", (event: Event)=> {
//         // event.preventDefault();
//         buildLigneProduit();
//         loadCategorieOptions(nbrLignProduit);
//         onChangeCategories(nbrLignProduit);
//         onDataLigneArticle();
//     });
//
//     venteFormHandler.handleSubmit(async (data) => {
//         const result = await dao.postData("/api/vente-add",data);
//         console.log(result);
//         venteFormHandler.resetForm();
//         // console.log(data);
//     })
//
// })()