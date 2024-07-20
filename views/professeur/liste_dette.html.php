<div class=" mx-[30px] min-h-[calc(100vh-195px)] mb-[30px] ssm:mt-[30px] mt-[15px]">


    <div class="grid grid-cols-12 gap-[25px]">
        <div class="col-span-12">
            <div class="bg-white dark:bg-box-dark m-0 p-0 text-body dark:text-subtitle-dark text-[15px] rounded-10 relative">
                <div class="px-[25px] text-dark dark:text-title-dark font-medium text-[17px] flex flex-wrap items-center justify-between max-sm:flex-col max-sm:h-auto border-b border-regular dark:border-box-dark-up">
                    <h1 class="mb-0 inline-flex items-center py-[16px] overflow-hidden whitespace-nowrap text-ellipsis text-[18px] font-semibold text-dark dark:text-title-dark capitalize">
                        Liste Dettes
                    </h1>
                    <div class="w-[80%] flex gap-[10px] justify-between flex-row items-center">
                        <div class="flex flex-col md:flex-row gap-[8px]">
                            <div class="text-20 underline font-semibold text-dark dark:text-title-dark">Client: <span><?= isset($clientFound) && !empty($clientFound) ? $clientFound->prenom . ' ' . $clientFound->nom : '' ?></span></div>
                        </div>
                        <div class="flex flex-col md:flex-row gap-[8px]">
                            <div class="text-20 underline font-semibold text-dark dark:text-title-dark">Téléphone: <span><?= isset($clientFound) && !empty($clientFound) ? $clientFound->telephone : '' ?></span></div>
                        </div>
                        <div class="flex md:justify-center flex-col md:flex-row gap-[8px]">
                            <form class="" action="/dettes/liste/filtre" method="POST">
                                <div class="flex flex-col flex-1 md:flex-row gap-3">
                                    <label for="name" class="w-[178px] inline-flex items-center mb-2 text-sm font-medium capitalize text-dark dark:text-title-dark">Etat Dette</label>
                                    <select name="etat" class="py-[11px] px-[20px] w-full capitalize text-body dark:text-white border-regular dark:border-box-dark-up border-1 rounded-6 dark:bg-box-dark-up outline-none">
                                        <?php foreach ($etat as $e) : ?>
                                            <option <?= isset($selectedEtat) && !empty($selectedEtat) && $selectedEtat == $e ? 'selected' : '' ?> value="<?= $e ?>"><?= $e ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit" class="px-[30px] h-[44px] text-white bg-primary border-primary hover:bg-primary-hbr font-medium rounded-4 text-sm w-full sm:w-auto text-center inline-flex items-center justify-center capitalize transition-all duration-300 ease-linear" data-te-ripple-init="" data-te-ripple-color="light">Filtrer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="p-[25px]">

                    <div class="overflow-x-auto scrollbar">
                        <table class="min-w-full text-sm font-light text-start">
                            <thead class="font-medium">
                                <tr>
                                    <th scope="col" class="bg-[#f8f9fb] dark:bg-box-dark-up px-4 py-3.5 text-start text-body dark:text-title-dark text-[15px] font-medium border-none before:hidden capitalize">
                                        Date</th>
                                    <th scope="col" class="bg-[#f8f9fb] dark:bg-box-dark-up px-4 py-3.5 text-start text-body dark:text-title-dark text-[15px] font-medium border-none before:hidden capitalize">
                                        Montant</th>
                                    <th scope="col" class="bg-[#f8f9fb] dark:bg-box-dark-up px-4 py-3.5 text-start text-body dark:text-title-dark text-[15px] font-medium border-none before:hidden capitalize">
                                        Restant</th>
                                    <th scope="col" class="bg-[#f8f9fb] dark:bg-box-dark-up px-4 py-3.5 text-start text-body dark:text-title-dark text-[15px] font-medium border-none before:hidden capitalize">
                                        Paiement</th>
                                    <th scope="col" class="bg-[#f8f9fb] dark:bg-box-dark-up px-4 py-3.5 text-end text-body dark:text-title-dark text-[15px] font-medium border-none before:hidden rounded-e-[6px] capitalize">
                                        List</th>
                                    <th scope="col" class="bg-[#f8f9fb] dark:bg-box-dark-up px-4 py-3.5 text-end text-body dark:text-title-dark text-[15px] font-medium border-none before:hidden rounded-e-[6px] capitalize">
                                        Articles</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($listesDettesDuClient) && !empty($listesDettesDuClient)) {
                                    foreach ($listesDettesDuClient as $dette) {
                                ?>
                                        <tr class="group">
                                            <td class="px-4 py-2.5 font-normal last:text-end capitalize text-[14px] text-dark dark:text-title-dark border-none group-hover:bg-transparent  whitespace-nowrap">
                                                <?= (new DateTime($dette->date))->format('d-m-Y') ?>
                                            </td>
                                            <td class="px-4 py-2.5 font-normal last:text-end lowercase text-[14px] text-dark dark:text-title-dark border-none group-hover:bg-transparent  whitespace-nowrap">
                                                <?= $dette->total_dette ?></td>
                                            <td class="px-4 py-2.5 font-normal last:text-end capitalize text-[14px] text-dark dark:text-title-dark border-none group-hover:bg-transparent  whitespace-nowrap">
                                                <?= (int)$dette->total_dette - (int)$dette->montant_verse ?></td>
                                            <td class="px-4 py-2.5 font-normal last:text-end capitalize text-[14px] text-dark dark:text-title-dark border-none group-hover:bg-transparent  whitespace-nowrap">
                                                <!-- <form action="/dettes/paiement" method="POST" class="<?= ((int)$dette->total_dette - (int)$dette->montant_verse) > 0 ? '' : 'hidden' ?>">
                                                    <input type="hidden" name="dette_id" value="<?= $dette->id ?>"> -->
                                                <!-- <button type="submit" class="px-[30px] h-[44px] text-white bg-primary border-primary hover:bg-primary-hbr font-medium rounded-4 text-sm w-full sm:w-auto text-center inline-flex items-center justify-center capitalize transition-all duration-300 ease-linear" data-te-ripple-init="" data-te-ripple-color="light">Payer</button> -->
                                                <!-- </form> -->
                                                <a href="/dettes/paiement/<?=$dette->id?>" class="<?= ((int)$dette->total_dette - (int)$dette->montant_verse) > 0 ? '' : 'hidden' ?> px-[30px] h-[44px] text-white bg-primary border-primary hover:bg-primary-hbr font-medium rounded-4 text-sm w-full sm:w-auto text-center inline-flex items-center justify-center capitalize transition-all duration-300 ease-linear">
                                                    Payer
                                                </a>
                                                <span class="<?= ((int)$dette->total_dette - (int)$dette->montant_verse) == 0 ? '' : 'hidden' ?> bg-success rounded-[15px] py-[4px] px-[8.23px] text-[12px] font-medium leading-[13px] text-center text-white">Payer Complétement</span>

                                            </td>
                                            <td class="ps-4 pe-4 py-2.5 font-normal last:text-end capitalize text-[14px] text-dark dark:text-title-dark border-none group-hover:bg-transparent rounded-e-[6px]  whitespace-nowrap">
                                                <form action="/dettes/paiement/liste" method="POST" class="<?= (int)$dette->montant_verse > 0 ? '' : 'hidden' ?>">
                                                    <input type="hidden" name="dette_id" value="<?= $dette->id ?>">
                                                    <button type="submit" class="px-[30px] h-[44px] text-white bg-primary border-primary hover:bg-primary-hbr font-medium rounded-4 text-sm w-full sm:w-auto text-center inline-flex items-center justify-center capitalize transition-all duration-300 ease-linear" data-te-ripple-init="" data-te-ripple-color="light">Voir</button>
                                                </form>
                                                <span class="<?= (int)$dette->montant_verse == 0 ? '' : 'hidden' ?> bg-danger rounded-[15px] py-[4px] px-[8.23px] text-[12px] font-medium leading-[13px] text-center text-white">Pas de paiement</span>
                                            </td>

                                            <td class="px-4 py-2.5 font-normal last:text-end capitalize text-[14px] text-dark dark:text-title-dark border-none group-hover:bg-transparent  whitespace-nowrap">

                                                <a href="/dettes/paiement/<?=$dette->id?>/articles" class="px-[30px] h-[44px] text-white bg-primary border-primary hover:bg-primary-hbr font-medium rounded-4 text-sm w-full sm:w-auto text-center inline-flex items-center justify-center capitalize transition-all duration-300 ease-linear">
                                                    Articles
                                                </a>
                                            </td>
                                        </tr>

                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                        <?= $paginationHtml ?>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>