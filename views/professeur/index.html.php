<?php
//    dd($user);
?>
<div class="grid grid-cols-12 gap-5">
        <div class="col-span-12">
            <div class="col-span-12 gap-[10px] flex flex-row p-[25px] rounded-10 bg-box-dark">
                <div class="mb-6 custom-date-input">
                    <label for="date" class="inline-flex items-center w-[178px] mb-2 text-sm font-medium capitalize text-title-dark">
                        Sélectionner un jour:
                    </label>
                    <input type="date" id="date" class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <div class="mb-6 custom-date-input">
                    <label for="week" class="inline-flex items-center w-[178px] mb-2 text-sm font-medium capitalize text-title-dark">
                        Sélectionner une semaine:
                    </label>
                    <input type="week" id="week" class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:focus:ring-green-500 dark:focus:border-green-500" />
                </div>

            </div>

         <div class="bg-box-dark overflow-x-auto scrollbar">
             <table class="min-w-full text-sm font-light text-start">
                 <thead class="font-medium">
                 <tr>
                     <th scope="col" class="bg-box-dark-up px-4 py-3.5 text-start text-title-dark text-[15px] font-medium border-none before:hidden capitalize">
                         Libelle Cours
                     </th>
                     <th scope="col" class="bg-box-dark-up px-4 py-3.5 text-start text-title-dark text-[15px] font-medium border-none before:hidden capitalize">
                         user
                     </th>
                     <th scope="col" class="bg-box-dark-up px-4 py-3.5 text-start text-title-dark text-[15px] font-medium border-none before:hidden capitalize">
                         user
                     </th>
                     <th scope="col" class="bg-box-dark-up px-4 py-3.5 text-start text-title-dark text-[15px] font-medium border-none before:hidden capitalize">
                         user
                     </th>
                     <th scope="col" class="bg-box-dark-up px-4 py-3.5 text-start text-title-dark text-[15px] font-medium border-none before:hidden capitalize">
                         user
                     </th>
                     <th scope="col" class="bg-box-dark-up px-4 py-3.5 text-start text-title-dark text-[15px] font-medium border-none before:hidden capitalize">
                         Actions
                     </th>
                 </tr>
                 </thead>
                 <tbody>
                     <tr class="group">
                         <td class="px-4 py-2.5 font-normal last:text-end capitalize text-[14px] text-title-dark border-none group-hover:bg-transparent  whitespace-nowrap">
                             Kellie Marquot
                         </td>
                         <td class="px-4 py-2.5 font-normal last:text-end capitalize text-[14px] text-title-dark border-none group-hover:bg-transparent  whitespace-nowrap">
                             Kellie Marquot
                         </td>
                         <td class="px-4 py-2.5 font-normal last:text-end capitalize text-[14px] text-title-dark border-none group-hover:bg-transparent  whitespace-nowrap">
                             Kellie Marquot
                         </td>
                         <td class="px-4 py-2.5 font-normal last:text-end capitalize text-[14px] text-title-dark border-none group-hover:bg-transparent  whitespace-nowrap">
                             Kellie Marquot
                         </td>
                         <td class="px-4 py-2.5 font-normal last:text-end capitalize text-[14px] text-title-dark border-none group-hover:bg-transparent  whitespace-nowrap">
                             Kellie Marquot
                         </td>
                         <td class="flex flex-col gap-[5px] ps-4 pe-[25px] py-2.5 font-normal last:text-end capitalize text-[14px] text-title-dark border-none group-hover:bg-transparent rounded-e-[4px]">
                             <a href="/prof/1/cours/1" class="flex-1 capitalize border-dashed border-1 border-light-extra text-[14px] bg-transparent hover:bg-white text-title-dark hover:text-dark
                             hover:border-white/10 font-semibold leading-[22px] inline-flex items-center justify-center rounded-[40px]
                             px-[2px] h-[44px] transition duration-300 ease-in-out">
                                 <span>Détails</span>
                             </a>
                             <a href="/prof/1/cours/1/sessions" class="flex-1 capitalize border-dashed border-1 border-light-extra text-[14px] bg-transparent hover:bg-white text-title-dark hover:text-dark
                             hover:border-white/10 font-semibold leading-[22px] inline-flex items-center justify-center rounded-[40px]
                             px-[2px] h-[44px] transition duration-300 ease-in-out">
                                 <span>Sessions</span>
                             </a>
                         </td>
                     </tr>
                 </tbody>
             </table>
             <div class="flex items-center md:justify-end pt-[40px]">
                 <nav aria-label="Page navigation example">
                     <ul class="flex items-center justify-center gap-2 list-style-none listItemActive">
                         <li>
                             <a class="relative flex justify-center items-center rounded bg-transparent h-[30px] w-[30px] transition-all duration-300 text-white hover:bg-box-dark-up hover:text-white  border border-box-dark-up  text-[13px] font-normal capitalize text-[rgb(64_64_64_/_var(--tw-text-opacity))] duration ease-in-out border-solid" href="#" aria-label="Previous">
                                 <i class="uil uil-angle-left text-[16px]"></i>
                             </a>
                         </li>
                         <li>
                             <a class="relative flex justify-center items-center border border-box-dark-up rounded h-[30px] w-[30px] text-sm transition-all duration-300 hover:bg-primary hover:text-white text-white bg-box-dark-up dark:hover:text-white [&amp;.active]:bg-primary [&amp;.active]:text-white active" href="#">1</a>
                         </li>
                         <li aria-current="page">
                             <a class="relative flex justify-center items-center border border-box-dark-up rounded h-[30px] w-[30px] text-sm transition-all duration-300 hover:bg-primary hover:text-white text-white bg-box-dark-up dark:hover:text-white [&amp;.active]:bg-primary [&amp;.active]:text-white" href="#">2</a>
                         </li>
                         <li>
                             <a class="relative flex justify-center items-center border border-box-dark-up rounded  h-[30px] w-[30px] text-sm transition-all duration-300 hover:bg-primary hover:text-white text-white bg-box-dark-up dark:hover:text-white [&amp;.active]:bg-primary [&amp;.active]:text-white" href="#">3</a>
                         </li>
                         <li>
                             <a class="relative flex justify-center items-center rounded bg-transparent h-[30px] w-[30px] transition-all duration-300 text-white hover:bg-box-dark-up hover:text-white  border border-box-dark-up text-[13px] font-normal capitalize text-[rgb(64_64_64_/_var(--tw-text-opacity))] duration ease-in-out border-solid cursor-pointer" href="#" aria-label="Next">
                                 <i class="uil uil-angle-right text-[16px]"></i>
                             </a>
                         </li>
                     </ul>
                 </nav>
             </div>
         </div>

     </div>
    </div>