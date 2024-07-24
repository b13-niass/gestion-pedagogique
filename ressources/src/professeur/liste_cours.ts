import {DAO} from "../Model/DAO.js";
import {IListCoursLoadData} from "../Interface/DataBinding.js";
import {Pagination} from "../Model/Pagination.js";
import {FormatDate} from "../Model/FormatDate.js";

(async () => {
    const preloaderId = document.getElementById("preloaderId") as HTMLInputElement;

    /** Variable Declaration **/
    const dao: DAO = new DAO();
    const idProfesseurElement = document.querySelector("[data-iduser]") as HTMLDivElement;
    let idProfesseur = parseInt(idProfesseurElement.dataset.iduser!);
    // console.log(idProfesseur);
    const listCoursLoadData: IListCoursLoadData[] = await dao.getData(`/api/prof/${idProfesseur}/cours`);
    const filterBars = document.querySelectorAll(".filter-bar") as NodeListOf<HTMLInputElement>;


    const listeCourElement: HTMLTableElement = document.getElementById("listeCours") as HTMLTableElement;
    let filterListeCour: IListCoursLoadData[] = [];
    let filterOptions:Record<string, any> = {};
    const paginationObject = new Pagination(filterListeCour, 3);

    /** Function Declaration **/

    const courseLine = (course: IListCoursLoadData): HTMLTableRowElement => {
        const tr: HTMLTableRowElement = document.createElement("tr");
        tr.className = "group";

        const classesStr = course.classes!.map(classe => classe.libelle).join(" / ");

        tr.innerHTML = `
        <td class="px-4 py-2.5 font-normal last:text-end capitalize text-[14px] text-title-dark border-none group-hover:bg-transparent  whitespace-nowrap">
            ${course.intitule}
        </td>
        <td class="px-4 py-2.5 font-normal last:text-end capitalize text-[14px] text-title-dark border-none group-hover:bg-transparent  whitespace-nowrap">
            ${course.module_name}
        </td>
        <td class="px-4 py-2.5 font-normal last:text-end capitalize text-[14px] text-title-dark border-none group-hover:bg-transparent  whitespace-nowrap">
            ${course.semestre_name}
        </td>
        <td class="px-4 py-2.5 font-normal last:text-end capitalize text-[14px] text-title-dark border-none group-hover:bg-transparent  whitespace-nowrap">
            ${classesStr}
        </td>
        <td class="px-4 py-2.5 font-normal last:text-end capitalize text-[14px] text-title-dark border-none group-hover:bg-transparent  whitespace-nowrap">
            ${course.heureGlobale}
        </td>
        <td class="flex flex-col gap-[5px] ps-4 pe-[25px] py-2.5 font-normal last:text-end capitalize text-[14px] text-title-dark border-none group-hover:bg-transparent rounded-e-[4px]">
            <a href="/prof/${idProfesseur}/cours/${course.id}" class="flex-1 capitalize border-dashed border-1 border-light-extra text-[14px] bg-transparent hover:bg-white text-title-dark hover:text-dark hover:border-white/10 font-semibold leading-[22px] inline-flex items-center justify-center rounded-[40px] px-[2px] h-[44px] transition duration-300 ease-in-out">
                <span>Détails</span>
            </a>
            <a href="/prof/${idProfesseur}/cours/${course.id}/sessions" class="flex-1 capitalize border-dashed border-1 border-light-extra text-[14px] bg-transparent hover:bg-white text-title-dark hover:text-dark hover:border-white/10 font-semibold leading-[22px] inline-flex items-center justify-center rounded-[40px] px-[2px] h-[44px] transition duration-300 ease-in-out">
                <span>Sessions</span>
            </a>
        </td>`;

        return tr;
    };
    const updateCourTable = () => {
        const tbody = document.getElementById("listeCours") as HTMLTableSectionElement;
        tbody.innerHTML = '';
        paginationObject.getPageItems().forEach((cour: IListCoursLoadData, index) => {
            const tr: HTMLTableRowElement = courseLine(cour);
            tbody.appendChild(tr);
        });
        paginationObject.makeFooter();
    }

    const filterCour = (filterOptions: Record<string, any>): IListCoursLoadData[] => {
        const result: IListCoursLoadData[] = [];
        listCoursLoadData!.forEach((cour: IListCoursLoadData) => {
            const d: IListCoursLoadData = {
                id: cour.id,
                intitule: cour.intitule,
                module_name: cour.module_name,
                semestre_name: cour.semestre_name,
                classes: cour.classes,
                heureGlobale: cour.heureGlobale,
                created_at: cour.created_at,
                updated_at: cour.updated_at
            };

            let cptFind: number = 0;

            for (const filterOptionsKey in filterOptions) {
                if (filterOptionsKey in d) {
                    const value = d[filterOptionsKey as keyof IListCoursLoadData];
                    if (typeof value === 'string' && value.toLowerCase().includes(filterOptions[filterOptionsKey].toLowerCase())) {
                        cptFind++;
                    } else if (typeof value === 'number' && value.toString().includes(filterOptions[filterOptionsKey].toString())) {
                        cptFind++;
                    }
                }
            }

            if (cptFind === Object.keys(filterOptions).length) {
                result.push(d);
            }
        });
        return result;
    };

    const onFilterBar = () => {
        filterBars.forEach((filterBar) => {
            filterBar.addEventListener("input", (event) =>{
                // Object.keys(filterOptions).some(key => key == filterBar.name)
                if (!filterBar.value){
                    delete filterOptions[filterBar.name];
                }else {
                    filterOptions[filterBar.name] = filterBar.value;
                }
                filterListeCour = filterCour(filterOptions);
                paginationObject.setItems(filterListeCour);
                paginationObject.goToPage(1);
                updateCourTable();
                onClickPaginationNav();
                onClickDetailsDette();
            })
        })
    }

    const onClickPaginationNav = () => {
        const btnsPaginate = document.querySelectorAll("[data-paginate]") as NodeListOf<HTMLButtonElement>;
        btnsPaginate.forEach((btn) => {
            btn.addEventListener("click", (event: Event) => {
                paginationObject.goToPage(parseInt(btn.dataset.paginate!));
                updateCourTable();
                onClickPaginationNav();
                onClickDetailsDette();
            })
        })
    }

    const onClickDetailsDette = () => {

    }

    /** Initialisation **/
    filterListeCour = filterCour(filterOptions);
    paginationObject.setItems(filterListeCour);
    paginationObject.makeFooter();
    // updateDetteTable();
    onFilterBar();
    onClickPaginationNav();
    onClickDetailsDette();
     preloaderId.classList.add("hidden");

    /** Event Declaration **/

})()