// import {DAO} from "../Model/DAO.js";
// import {IDetteListe, IListDetteLoadData} from "../Interface/DataBinding.js";
// import {Pagination} from "../Model/Pagination.js";
// import {FormatDate} from "../Model/FormatDate.js";
//
// (async () => {
//     const preloaderId = document.getElementById("preloaderId") as HTMLInputElement;
//
//     /** Variable Declaration **/
//     const dao: DAO = new DAO();
//     const listDetteLoadData: IListDetteLoadData = await dao.getData("api/loadpage/dette-list");
//     const filterBars = document.querySelectorAll(".filter-bar") as NodeListOf<HTMLInputElement>;
//     const dateDebut_search = document.getElementById("dateDebut_search") as HTMLInputElement;
//     const dateFin_search = document.getElementById("dateFin_search") as HTMLInputElement;
//
//     const listeDetteElement: HTMLTableElement = document.getElementById("listeDette") as HTMLTableElement;
//     let filterListeDette: IDetteListe[] = [];
//     let filterOptions:Record<string, any> = {};
//     const paginationObject = new Pagination(filterListeDette, 3);
//
//
//     /** Function Declaration **/
//
//     const detteLine = (dette: IDetteListe): HTMLTableRowElement => {
//         const formatDate = new FormatDate();
//         const tr: HTMLTableRowElement = document.createElement("tr");
//         tr.className = "group";
//         tr.innerHTML = `
//          <td class="px-4 py-2.5 font-normal last:text-end capitalize text-[14px] text-dark dark:text-title-dark border-none group-hover:bg-transparent  whitespace-nowrap">
//                 ${dette.nom_client}</td>
//             <td class="px-4 py-2.5 font-normal last:text-end lowercase text-[14px] text-dark dark:text-title-dark border-none group-hover:bg-transparent  whitespace-nowrap">
//                 ${dette.telephone_client}</td>
//             <td class="px-4 py-2.5 font-normal last:text-end capitalize text-[14px] text-dark dark:text-title-dark border-none group-hover:bg-transparent  whitespace-nowrap">
//                 ${dette.date_dette}</td>
//             <td class="px-4 py-2.5 font-normal last:text-end capitalize text-[14px] text-dark dark:text-title-dark border-none group-hover:bg-transparent  whitespace-nowrap">
//                 ${dette.montant_dette}</td>
//             <td class="px-4 py-[10px]font-medium text-end capitalize  text-[14px] text-dark dark:text-title-dark border-none group hover:bg-primary/10-hover:bg-transparent rounded-e-[6px] whitespace-nowrap">
//                 <div class="flex items-center gap-y-[10px] gap-x-[10px] justify-end">
//                     <div class="flex items-center" data-te-dropdown-ref="">
//                         <button class="text-[18px] z-998 text-light dark:text-subtitle-dark" type="button" id="contact-" data-te-dropdown-toggle-ref="" aria-expanded="false">
//                             <i class="uil uil-ellipsis-v text-[18px] text-light-extra"></i>
//                         </button>
//                         <ul class="absolute z-[1000] ltr:float-left rtl:float-right hidden min-w-max list-none overflow-hidden rounded-lg border-none bg-white bg-clip-padding text-left text-base shadow-lg dark:shadow-boxLargeDark dark:bg-box-dark-down [&amp;[data-te-dropdown-show]]:block opacity-100 px-[15px] py-[10px]" aria-labelledby="contact-" data-te-dropdown-menu-ref="">
//                             <li>
//                                 <a href="#" data-idDette="${dette.id_dette}" class="flex items-center gap-[10px] mb-[10px] capitalize text-light dark:text-subtitle-dark group hover:bg-primary/10 hover:text-primary text-[14px]">
//                                     <i class="uil uil-eye text-body dark:text-subtitle-dark group hover:bg-primary/10-hover:text-current text-[15px]"></i>
//                                     Voir Détails
//                                 </a>
//                             </li>
//                         </ul>
//                     </div>
//                 </div>
//             </td>`;
//         return tr;
//     }
//
//     const updateDetteTable = () => {
//         const tbody = document.getElementById("listeDette") as HTMLTableSectionElement;
//         tbody.innerHTML = '';
//         paginationObject.getPageItems().forEach((dette: IDetteListe, index) => {
//             const tr: HTMLTableRowElement = detteLine(dette);
//             tbody.appendChild(tr);
//         });
//         paginationObject.makeFooter();
//     }
//
//     const filterDette = (filterOptions: Record<string, any>): IDetteListe[] => {
//         const result: IDetteListe[] = [];
//         listDetteLoadData.dettes!.forEach((dette: IDetteListe) => {
//             const d: IDetteListe = {
//                 id_dette: dette.id_dette,
//                 date_dette: dette.date_dette,
//                 nom_client: dette.nom_client,
//                 montant_dette: dette.montant_dette,
//                 telephone_client: dette.telephone_client
//             };
//
//             let cptFind: number = 0;
//
//             for (const filterOptionsKey in filterOptions) {
//                 if (filterOptionsKey in d) {
//                     const value = d[filterOptionsKey as keyof IDetteListe];
//                     if (typeof value === 'string' && value.toLowerCase().includes(filterOptions[filterOptionsKey].toLowerCase())) {
//                         cptFind++;
//                     } else if (typeof value === 'number' && value.toString().includes(filterOptions[filterOptionsKey].toString())) {
//                         cptFind++;
//                     }
//                 }
//             }
//
//             if (cptFind === Object.keys(filterOptions).length) {
//                 result.push(d);
//             }
//         });
//         return result;
//     };
//
//     const onFilterBar = () => {
//         filterBars.forEach((filterBar) => {
//             filterBar.addEventListener("input", (event) =>{
//                 // Object.keys(filterOptions).some(key => key == filterBar.name)
//                 if (!filterBar.value){
//                     delete filterOptions[filterBar.name];
//                 }else {
//                     filterOptions[filterBar.name] = filterBar.value;
//                 }
//                 console.log(filterOptions)
//                 filterListeDette = filterDette(filterOptions);
//                 paginationObject.setItems(filterListeDette);
//                 paginationObject.goToPage(1);
//                 updateDetteTable();
//                 onClickPaginationNav();
//                 onClickDetailsDette();
//             })
//         })
//     }
//
//     const onClickPaginationNav = () => {
//         const btnsPaginate = document.querySelectorAll("[data-paginate]") as NodeListOf<HTMLButtonElement>;
//         btnsPaginate.forEach((btn) => {
//             btn.addEventListener("click", (event: Event) => {
//                 paginationObject.goToPage(parseInt(btn.dataset.paginate!));
//                 updateDetteTable();
//                 onClickPaginationNav();
//                 onClickDetailsDette();
//             })
//         })
//     }
//
//     const onClickDetailsDette = () => {
//
//     }
//
//     /** Initialisation **/
//     filterListeDette = filterDette(filterOptions);
//     paginationObject.setItems(filterListeDette);
//     paginationObject.makeFooter();
//     // updateDetteTable();
//     onFilterBar();
//     onClickPaginationNav();
//     onClickDetailsDette();
//     preloaderId.classList.add("hidden");
//
//     /** Event Declaration **/
//     dateDebut_search.addEventListener("change", (event) => {
//         dateFin_search.min = dateDebut_search.value;
//     });
//     dateFin_search.addEventListener("change", (event) => {
//         dateDebut_search.max = dateFin_search.value;
//     })
//
// })()