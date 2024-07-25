import { DAO } from "../Model/DAO.js";
import { Pagination } from "../Model/Pagination.js";
(async () => {
    const preloaderId = document.getElementById("preloaderId");
    /** Variable Declaration **/
    const dao = new DAO();
    const idEtudiantElement = document.querySelector("[data-iduser]");
    let idEtudiant = parseInt(idEtudiantElement.dataset.iduser);
    // console.log(idEtudiant);
    const listCoursLoadData = await dao.getData(`/api/etu/${idEtudiant}/absences`);
    console.log(listCoursLoadData);
    const filterBars = document.querySelectorAll(".filter-bar");
    const myModalJustification = document.getElementById("myModal");
    const justificationText = document.getElementById("justificationText");
    const justificationFile = document.getElementById("justificationFile");
    const etudiantJustification = document.getElementById("etudiantJustification");
    const sessionJustification = document.getElementById("sessionJustification");
    const justificationForm = document.getElementById("justificationForm");
    const closeModalBtn = document.getElementById('closeModalBtn');
    const listeCourElement = document.getElementById("listeCours");
    let filterListeCour = [];
    let filterOptions = {};
    const paginationObject = new Pagination(filterListeCour, 3);
    /** Function Declaration **/
    const courseLine = (course) => {
        const tr = document.createElement("tr");
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
                <button data-idetu="${idEtudiant}" data-idsession="${course.id}" class="${course.justificatif == true ? "hidden" : ""} justificatif-btn flex-1 capitalize border-dashed border-1 border-light-extra text-[14px] bg-transparent hover:bg-white text-title-dark hover:text-dark
                 hover:border-white/10 font-semibold leading-[22px] inline-flex items-center justify-center rounded-[40px]
                 px-[2px] h-[44px] transition duration-300 ease-in-out">
                    <span>Justificatif </span>
                </button>
                <span class="text-warning ${course.justificatif == true ? "" : "hidden"} text-sm">Justificatif envoyé</span>
            </td>
        `;
        return tr;
    };
    const updateCourTable = () => {
        const tbody = document.getElementById("listeCours");
        tbody.innerHTML = '';
        paginationObject.getPageItems().forEach((cour, index) => {
            const tr = courseLine(cour);
            tbody.appendChild(tr);
        });
        paginationObject.makeFooter();
    };
    const filterCour = (filterOptions) => {
        const result = [];
        listCoursLoadData.forEach((cour) => {
            const d = {
                id: cour.id,
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
            let cptFind = 0;
            for (const filterOptionsKey in filterOptions) {
                if (filterOptionsKey in d) {
                    const value = d[filterOptionsKey];
                    if (typeof value === 'string' && value.toLowerCase().includes(filterOptions[filterOptionsKey].toLowerCase())) {
                        cptFind++;
                    }
                    else if (typeof value === 'number' && value.toString().includes(filterOptions[filterOptionsKey].toString())) {
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
            filterBar.addEventListener("input", (event) => {
                // Object.keys(filterOptions).some(key => key == filterBar.name)
                if (!filterBar.value) {
                    delete filterOptions[filterBar.name];
                }
                else {
                    filterOptions[filterBar.name] = filterBar.value;
                }
                filterListeCour = filterCour(filterOptions);
                paginationObject.setItems(filterListeCour);
                paginationObject.goToPage(1);
                updateCourTable();
                onClickPaginationNav();
                onClickJustificatif();
            });
        });
    };
    const onClickPaginationNav = () => {
        const btnsPaginate = document.querySelectorAll("[data-paginate]");
        btnsPaginate.forEach((btn) => {
            btn.addEventListener("click", (event) => {
                paginationObject.goToPage(parseInt(btn.dataset.paginate));
                updateCourTable();
                onClickPaginationNav();
                onClickJustificatif();
            });
        });
    };
    const onClickJustificatif = () => {
        const btnJustificatif = document.querySelectorAll(".justificatif-btn");
        btnJustificatif.forEach((justificatif) => {
            justificatif.addEventListener("click", (event) => {
                let idEtudiant = parseInt(justificatif.dataset.idetu);
                let idSession = parseInt(justificatif.dataset.idsession);
                myModalJustification.classList.remove("hidden");
                etudiantJustification.value = "" + idEtudiant;
                sessionJustification.value = "" + idSession;
                justificationForm.action = `/etu/${idEtudiant}/absences/${idSession}`;
            });
        });
    };
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
    closeModalBtn.addEventListener('click', function () {
        myModalJustification.classList.add('hidden');
    });
})();
