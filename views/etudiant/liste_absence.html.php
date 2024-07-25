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
                    <option value="Algèbre" >Algèbre</option>
                    <option value="Physique Fondamentale" >Physique Fondamentale</option>
                </select>
            </div>
        </div>

        <div data-iduser="<?=$user->id?>" class="bg-box-dark overflow-x-auto scrollbar">
            <table class="min-w-full text-sm font-light text-start">
                <thead class="font-medium">
                <tr>
                    <th scope="col" class="bg-box-dark-up px-4 py-3.5 text-start text-title-dark text-[15px] font-medium border-none before:hidden capitalize">
                        Modules
                    </th>
                    <th scope="col" class="bg-box-dark-up px-4 py-3.5 text-start text-title-dark text-[15px] font-medium border-none before:hidden capitalize">
                        Date Début
                    </th>
                    <th scope="col" class="bg-box-dark-up px-4 py-3.5 text-start text-title-dark text-[15px] font-medium border-none before:hidden capitalize">
                        Date Fin
                    </th>
                    <th scope="col" class="bg-box-dark-up px-4 py-3.5 text-start text-title-dark text-[15px] font-medium border-none before:hidden capitalize">
                        Actions
                    </th>
                </tr>
                </thead>
                <tbody id="listeCours">
                    <?php foreach ($cours_absence as $key => $absence):
                        if ($key == 3){
                            break;
                        }
                        ?>
                        <tr class="group">
                            <td class="px-4 py-2.5 font-normal last:text-end capitalize text-[14px] text-title-dark border-none group-hover:bg-transparent  whitespace-nowrap">
                                <?= $absence->module_name ?>
                            </td>
                            <td class="px-4 py-2.5 font-normal last:text-end capitalize text-[14px] text-title-dark border-none group-hover:bg-transparent  whitespace-nowrap">
                                <?=$absence->heureDebut?>
                            </td>
                            <td class="px-4 py-2.5 font-normal last:text-end capitalize text-[14px] text-title-dark border-none group-hover:bg-transparent  whitespace-nowrap">
                                <?= $absence->heureFin ?>
                            </td>
                            <td class="flex flex-col gap-[5px] ps-4 pe-[25px] py-2.5 font-normal last:text-end capitalize text-[14px] text-title-dark border-none group-hover:bg-transparent rounded-e-[4px]">
                                <button data-idetu="<?=$user->id?>" data-idsession="<?= $absence->id ?>" class=" <?= $absence->justificatif ? "hidden" : '' ?> justificatif-btn flex-1 capitalize border-dashed border-1 border-light-extra text-[14px] bg-transparent hover:bg-white text-title-dark hover:text-dark
                                 hover:border-white/10 font-semibold leading-[22px] inline-flex items-center justify-center rounded-[40px]
                                 px-[2px] h-[44px] transition duration-300 ease-in-out">
                                    <span>Justificatif</span>
                                </button>
                                <span class="text-warning <?= $absence->justificatif ? '' : "hidden" ?> text-sm">Justificatif envoyé</span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div id="paginationBar" class="flex items-center md:justify-end pt-[40px]">

            </div>
        </div>

    </div>
</div>


<!-- Modal -->
<div id="myModal" class="hidden fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75">
    <div class="bg-white p-8 rounded-lg shadow-lg w-1/3">
        <h2 class="text-xl mb-4">Envoyer Justification</h2>
        <form id="justificationForm" action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" id="etudiantJustification" name="etudiantJustification" class="mt-1 p-2 border border-gray-300 rounded w-full">
            <input type="hidden" id="sessionJustification" name="sessionJustification" class="mt-1 p-2 border border-gray-300 rounded w-full">

            <div class="mb-4">
                <label for="justificationText" class="block text-gray-700">Texte Justification:</label>
                <input type="text" id="justificationText" name="justificationText" class="mt-1 p-2 border border-gray-300 rounded w-full">
            </div>
            <div class="h-[62px] w-full">
                <div class="h-[62px] flex items-center justify-center w-full">
                    <label for="dropzone-file" class="h-[62px] flex flex-col items-center justify-center w-full ssm:h-[62px] transition-all duration-300 ease-linear bg-white border-2 border-gray-300 border-dashed rounded-lg cursor-pointer hover:bg-bray-800bg-box-dark-up  border-box-dark-up hover:border-gray-500 hover:bg-gray-600">
                        <div class="flex flex-col items-center justify-center py-5">
                            <p class="text-[15px] text-light font-medium dark:text-subtitle-dark">
                                Ajouter Justificatif
                            </p>
                        </div>
                        <input id="dropzone-file" name="fichier" type="file" class="hidden" />
                    </label>
                </div>
<!--                <span class="text-danger text-sm --><?php //isset($errorForm['photo']) && !empty($errorForm['photo']) ? 'visible' : 'invisible' ?><!--">--><?php //= isset($errorForm['photo']) && !empty($errorForm['photo']) ? $errorForm['photo'] : '' ?><!--</span>-->
            </div>
            <div class="flex justify-end">
                <button type="button" id="closeModalBtn" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Envoyer</button>
            </div>
        </form>
    </div>
</div>

<script src="<?= rsPath ?>/etudiant/liste_absence.js" type="module"></script>

