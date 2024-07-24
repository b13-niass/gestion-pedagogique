<?php
//    dd($user);
?>
<div class="grid grid-cols-12 gap-5">
    <div class="col-span-12">
        <div class="col-span-12 gap-[10px] flex flex-row p-[25px] rounded-10 bg-box-dark">
            <div class="content col-span-12 xl:col-span-2">
                <label for="module" class="inline-flex items-center w-[178px] mb-2 text-sm font-medium capitalize text-white dark:text-title-dark">Par module</label>
                <select id="module" name="module_name" class="filter-bar py-[11px] px-[20px] w-full capitalize text-body dark:text-white border-regular dark:border-box-dark-up border-1 rounded-6 dark:bg-box-dark-up outline-none mb-[20px]">
                    <option value="" selected>Selectionner Module</option>
                    <option value="Mathématiques Avancées" >Mathématiques Avancées</option>
                    <option value="Physique Fondamentale" >Physique Fondamentale</option>
                </select>
            </div>
            <div class="content col-span-12 xl:col-span-2">
                <label for="semestre" class="inline-flex items-center w-[178px] mb-2 text-sm font-medium capitalize text-white dark:text-title-dark">Par Semestre</label>
                <select id="semestre" name="semestre_name" class="filter-bar py-[11px] px-[20px] w-full capitalize text-body dark:text-white border-regular dark:border-box-dark-up border-1 rounded-6 dark:bg-box-dark-up outline-none mb-[20px]">
                    <option value="" selected>Selectionner Semestre</option>
                    <option value="Semestre 1">Semestre 1</option>
                    <option value="Semestre 2">Semestre 2</option>
                </select>
            </div>
        </div>

        <div data-iduser="<?=$user->id?>" class="bg-box-dark overflow-x-auto scrollbar">
            <table class="min-w-full text-sm font-light text-start">
                <thead class="font-medium">
                <tr>
                    <th scope="col" class="bg-box-dark-up px-4 py-3.5 text-start text-title-dark text-[15px] font-medium border-none before:hidden capitalize">
                        Intitulé
                    </th>
                    <th scope="col" class="bg-box-dark-up px-4 py-3.5 text-start text-title-dark text-[15px] font-medium border-none before:hidden capitalize">
                        Modules
                    </th>
                    <th scope="col" class="bg-box-dark-up px-4 py-3.5 text-start text-title-dark text-[15px] font-medium border-none before:hidden capitalize">
                        Semestres
                    </th>
                    <th scope="col" class="bg-box-dark-up px-4 py-3.5 text-start text-title-dark text-[15px] font-medium border-none before:hidden capitalize">
                        Classes
                    </th>
                    <th scope="col" class="bg-box-dark-up px-4 py-3.5 text-start text-title-dark text-[15px] font-medium border-none before:hidden capitalize">
                        Heure Global
                    </th>
                    <th scope="col" class="bg-box-dark-up px-4 py-3.5 text-start text-title-dark text-[15px] font-medium border-none before:hidden capitalize">
                        Actions
                    </th>
                </tr>
                </thead>
                <tbody id="listeCours">
                <?php foreach ($cours as $key => $cour):
                    if ($key == 3){
                        break;
                    }
                    ?>

                    <tr class="group">
                        <td class="px-4 py-2.5 font-normal last:text-end capitalize text-[14px] text-title-dark border-none group-hover:bg-transparent  whitespace-nowrap">
                            <?= $cour->intitule ?>
                        </td>
                        <td class="px-4 py-2.5 font-normal last:text-end capitalize text-[14px] text-title-dark border-none group-hover:bg-transparent  whitespace-nowrap">
                            <?= $cour->module_name ?>
                        </td>
                        <td class="px-4 py-2.5 font-normal last:text-end capitalize text-[14px] text-title-dark border-none group-hover:bg-transparent  whitespace-nowrap">
                            <?= $cour->semestre_name ?>
                        </td>
                        <td class="px-4 py-2.5 font-normal last:text-end capitalize text-[14px] text-title-dark border-none group-hover:bg-transparent  whitespace-nowrap">
                            <?php foreach ($cour->classes as $classe):  echo $classe->libelle." / ";  endforeach;?>
                        </td>
                        <td class="px-4 py-2.5 font-normal last:text-end capitalize text-[14px] text-title-dark border-none group-hover:bg-transparent  whitespace-nowrap">
                            <?= $cour->heureGlobale ?>
                        </td>
                        <td class="flex flex-col gap-[5px] ps-4 pe-[25px] py-2.5 font-normal last:text-end capitalize text-[14px] text-title-dark border-none group-hover:bg-transparent rounded-e-[4px]">
                            <a href="/etu/<?=$user->id?>/cours/<?=$cour->id?>" class="flex-1 capitalize border-dashed border-1 border-light-extra text-[14px] bg-transparent hover:bg-white text-title-dark hover:text-dark
                             hover:border-white/10 font-semibold leading-[22px] inline-flex items-center justify-center rounded-[40px]
                             px-[2px] h-[44px] transition duration-300 ease-in-out">
                                <span>Détails</span>
                            </a>
                            <a href="/etu/<?=$user->id?>/cours/<?=$cour->id?>/sessions" class="flex-1 capitalize border-dashed border-1 border-light-extra text-[14px] bg-transparent hover:bg-white text-title-dark hover:text-dark
                             hover:border-white/10 font-semibold leading-[22px] inline-flex items-center justify-center rounded-[40px]
                             px-[2px] h-[44px] transition duration-300 ease-in-out">
                                <span>Sessions</span>
                            </a>
                        </td>
                    </tr>

                <?php endforeach; ?>
                </tbody>
            </table>
            <div id="paginationBar" class="flex items-center md:justify-end pt-[40px]">
                <!--                 <nav aria-label="Page navigation example">-->
                <!--                     <ul class="flex items-center justify-center gap-2 list-style-none listItemActive">-->
                <!--                         <li>-->
                <!--                             <a class="relative flex justify-center items-center rounded bg-transparent h-[30px] w-[30px] transition-all duration-300 text-white hover:bg-box-dark-up hover:text-white  border border-box-dark-up  text-[13px] font-normal capitalize text-[rgb(64_64_64_/_var(--tw-text-opacity))] duration ease-in-out border-solid" href="#" aria-label="Previous">-->
                <!--                                 <i class="uil uil-angle-left text-[16px]"></i>-->
                <!--                             </a>-->
                <!--                         </li>-->
                <!--                         <li>-->
                <!--                             <a class="relative flex justify-center items-center border border-box-dark-up rounded h-[30px] w-[30px] text-sm transition-all duration-300 hover:bg-primary hover:text-white text-white bg-box-dark-up dark:hover:text-white [&amp;.active]:bg-primary [&amp;.active]:text-white active" href="#">1</a>-->
                <!--                         </li>-->
                <!--                         <li aria-current="page">-->
                <!--                             <a class="relative flex justify-center items-center border border-box-dark-up rounded h-[30px] w-[30px] text-sm transition-all duration-300 hover:bg-primary hover:text-white text-white bg-box-dark-up dark:hover:text-white [&amp;.active]:bg-primary [&amp;.active]:text-white" href="#">2</a>-->
                <!--                         </li>-->
                <!--                         <li>-->
                <!--                             <a class="relative flex justify-center items-center border border-box-dark-up rounded  h-[30px] w-[30px] text-sm transition-all duration-300 hover:bg-primary hover:text-white text-white bg-box-dark-up dark:hover:text-white [&amp;.active]:bg-primary [&amp;.active]:text-white" href="#">3</a>-->
                <!--                         </li>-->
                <!--                         <li>-->
                <!--                             <a class="relative flex justify-center items-center rounded bg-transparent h-[30px] w-[30px] transition-all duration-300 text-white hover:bg-box-dark-up hover:text-white  border border-box-dark-up text-[13px] font-normal capitalize text-[rgb(64_64_64_/_var(--tw-text-opacity))] duration ease-in-out border-solid cursor-pointer" href="#" aria-label="Next">-->
                <!--                                 <i class="uil uil-angle-right text-[16px]"></i>-->
                <!--                             </a>-->
                <!--                         </li>-->
                <!--                     </ul>-->
                <!--                 </nav>-->
            </div>
        </div>

    </div>
</div>

<script src="<?= rsPath ?>/etudiant/liste_cours.js" type="module"></script>
