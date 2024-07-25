import {DAO} from "../Model/DAO.js";
import {IListSessionsLoadData} from "../Interface/DataBinding.js";
import {Pagination} from "../Model/Pagination.js";
import {FormatDate} from "../Model/FormatDate.js";

(async () => {
    const preloaderId = document.getElementById("preloaderId") as HTMLInputElement;

    /** Variable Declaration **/
    const dao: DAO = new DAO();
    const idEtudiantElement = document.querySelector("[data-iduser]") as HTMLDivElement;
    let idEtudiant = parseInt(idEtudiantElement.dataset.iduser!);
    // console.log(idEtudiant);
    const listCoursLoadData: IListSessionsLoadData[] = await dao.getData(`/api/etu/${idEtudiant}/absences`);
    console.log(listCoursLoadData);
    const filterBars = document.querySelectorAll(".filter-bar") as NodeListOf<HTMLInputElement>;
    const myModalJustification = document.getElementById("myModal") as HTMLDivElement;
    const justificationText = document.getElementById("justificationText") as HTMLInputElement;
    const justificationFile = document.getElementById("justificationFile") as HTMLInputElement;
    const etudiantJustification = document.getElementById("etudiantJustification") as HTMLInputElement;
    const sessionJustification = document.getElementById("sessionJustification") as HTMLInputElement;
    const justificationForm = document.getElementById("justificationForm") as HTMLFormElement;
    const closeModalBtn = document.getElementById('closeModalBtn') as HTMLButtonElement;


    const listeCourElement: HTMLTableElement = document.getElementById("listeCours") as HTMLTableElement;
    let filterListeCour: IListSessionsLoadData[] = [];
    let filterOptions:Record<string, any> = {};
    const paginationObject = new Pagination(filterListeCour, 3);

    /** Function Declaration **/

    const courseLine = (course: IListSessionsLoadData): HTMLTableRowElement => {
        const tr: HTMLTableRowElement = document.createElement("tr");
        tr.className = "group";

        tr.innerHTML = `
            <td class="px-4 py-2.5 font-normal last:text-end capitalize text-[14px] text-title-dark border-none group-hover:bg-transparent  whitespace-nowrap">
                ${course.module_name}
            </td>
            <td class="px-4 py-2.5 font-normal last:text-end capitalize text-[14px] text-title-dark border-none group-hover:bg-transparent  whitespace-nowrap">
                 ${course.heureDebut}
            </td>
            <td class="px-4 py-2.5 font-normal last:text-end capitalize text-[14px] text-title-dark border-none group-hover:bg-transparent  whitespace-nowrap">
                ${course.heureFin}
            </td>
            <td class="flex flex-col gap-[5px] ps-4 pe-[25px] py-2.5 font-normal last:text-end capitalize text-[14px] text-title-dark border-none group-hover:bg-transparent rounded-e-[4px]">
                <button data-idetu="${idEtudiant}" data-idsession="${course.id}" class="${course.justificatif == true ? "hidden" : "" } justificatif-btn flex-1 capitalize border-dashed border-1 border-light-extra text-[14px] bg-transparent hover:bg-white text-title-dark hover:text-dark
                 hover:border-white/10 font-semibold leading-[22px] inline-flex items-center justify-center rounded-[40px]
                 px-[2px] h-[44px] transition duration-300 ease-in-out">
                    <span>Justificatif </span>
                </button>
                <span class="text-warning ${course.justificatif == true ? "" : "hidden" } text-sm">Justificatif envoyé</span>
            </td>
        `;

        return tr;
    };
    const updateCourTable = () => {
        const tbody = document.getElementById("listeCours") as HTMLTableSectionElement;
        tbody.innerHTML = '';
        paginationObject.getPageItems().forEach((cour: IListSessionsLoadData, index) => {
            const tr: HTMLTableRowElement = courseLine(cour);
            tbody.appendChild(tr);
        });
        paginationObject.makeFooter();
    }

    const filterCour = (filterOptions: Record<string, any>): IListSessionsLoadData[] => {
        const result: IListSessionsLoadData[] = [];
        listCoursLoadData!.forEach((cour: IListSessionsLoadData) => {
            const d: IListSessionsLoadData = {
                id:cour.id,
                cour_id: cour.cour_id,
                created_at: cour.created_at,
                date_session: cour.date_session,
                etat_avancement: cour.etat_avancement,
                etat_global: cour.etat_global,
                heureDebut: cour.heureDebut,
                heureFin: cour.heureFin,
                module_name: cour.module_name,
                presence: cour.presence,
                salle_id: cour.salle_id,
                updated_at: cour.updated_at,
                justificatif: cour.justificatif
            };

            let cptFind: number = 0;

            for (const filterOptionsKey in filterOptions) {
                if (filterOptionsKey in d) {
                    const value = d[filterOptionsKey as keyof IListSessionsLoadData];
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
                onClickJustificatif();
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
                onClickJustificatif();
            })
        })
    }

    const onClickJustificatif = () => {
        const btnJustificatif = document.querySelectorAll(".justificatif-btn") as NodeListOf<HTMLButtonElement>;
        btnJustificatif.forEach((justificatif) => {
            justificatif.addEventListener("click", (event) => {
                let idEtudiant = parseInt(justificatif.dataset.idetu!);
                let idSession = parseInt(justificatif.dataset.idsession!);

                myModalJustification.classList.remove("hidden");
                etudiantJustification.value = ""+idEtudiant;
                sessionJustification.value = ""+idSession;
                justificationForm.action = `/etu/${idEtudiant}/absences/${idSession}`;
            })
        } )
    }

    /** Initialisation **/
    filterListeCour = filterCour(filterOptions);
    console.log(filterListeCour);
    paginationObject.setItems(filterListeCour);
    paginationObject.makeFooter();
    // updateDetteTable();
    onFilterBar();
    onClickPaginationNav();
    onClickJustificatif();
    preloaderId.classList.add("hidden");

    /** Event Declaration **/
    closeModalBtn.addEventListener('click', function() {
        myModalJustification.classList.add('hidden');
    });
})()