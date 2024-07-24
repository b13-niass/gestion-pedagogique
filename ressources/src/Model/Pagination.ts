export class Pagination<T> {
  private items: T[];
  private currentPage: number;
  private itemsPerPage: number;

  constructor(items: T[], itemsPerPage: number) {
    this.items = items;
    this.itemsPerPage = itemsPerPage;
    this.currentPage = 1;
  }

  setItems(items: T[]) {
    this.items = items;
  }

  getItemsPerPage(): number {
    return this.itemsPerPage;
  }

  getNbrItems():number{
    return this.items.length;
  }

  getCurrentPage(): number {
    return this.currentPage;
  }

  getTotalPages(): number {
    return Math.ceil(this.items.length / this.itemsPerPage);
  }

  getPageItems(page: number = this.currentPage): T[] {
    const start = (page - 1) * this.itemsPerPage;
    const end = start + this.itemsPerPage;
    this.goToPage(page)
    return this.items.slice(start, end);
  }

  startPage():number{
    return (this.currentPage * this.itemsPerPage) - this.itemsPerPage;
  }

  endPage():number{
    return (this.currentPage * this.itemsPerPage);
  }

  nextPage(): number {
    if (this.currentPage < this.getTotalPages()) {
      this.currentPage = ++this.currentPage;
    }else {
      this.currentPage = this.getTotalPages();
    }
    return this.currentPage;
  }

  previousPage(): number {
    if (this.currentPage > 1) {
      this.currentPage = --this.currentPage;
    }else {
      this.currentPage = 1;
    }
    return this.currentPage;
  }

  goToPage(page: number): void {
    if (page >= 1 && page <= this.getTotalPages()) {
      this.currentPage = page;
    }
  }
  makeFooter(): void {
    const currentPage = this.getCurrentPage();
    const itemsPerPage = this.getItemsPerPage();
    const totalItems = this.getNbrItems();
    const totalPages = this.getTotalPages();
    const previousPage = currentPage > 1 ? currentPage - 1 : 1;
    const nextPage = currentPage < totalPages ? currentPage + 1 : totalPages;
    const paginationBar = document.getElementById("paginationBar") as HTMLDivElement;
    paginationBar.innerHTML = '';

    let paginationItems = '';

    // Previous Page
    paginationItems += `
        <li>
            <a class="relative flex justify-center items-center rounded bg-transparent h-[30px] w-[30px] text-light transition-all duration-300 dark:text-white dark:hover:bg-box-dark-up dark:hover:text-white border border-regular dark:border-box-dark-up text-[13px] font-normal capitalize text-[rgb(64_64_64_/_var(--tw-text-opacity))] duration ease-in-out border-solid hover:bg-primary hover:text-white cursor-pointer" href="#" aria-label="Previous" data-paginate="${previousPage}">
                <i class="uil uil-angle-left text-[16px]"></i>
            </a>
        </li>`;

    // Page Numbers
    for (let page = 1; page <= totalPages; page++) {
      const activeClass = page === currentPage ? 'active' : '';
      paginationItems += `
            <li>
                <a class="relative flex justify-center items-center border border-regular dark:border-box-dark-up rounded bg-white text-dark h-[30px] w-[30px] text-sm transition-all duration-300 hover:bg-primary hover:text-white dark:text-white dark:bg-box-dark-up dark:hover:text-white [&.active]:bg-primary [&.active]:text-white ${activeClass}" href="#" data-paginate="${page}">
                    ${page}
                </a>
            </li>`;
    }

    // Next Page
    paginationItems += `
        <li>
            <a class="relative flex justify-center items-center rounded bg-transparent h-[30px] w-[30px] text-light transition-all duration-300 dark:text-white dark:hover:bg-box-dark-up dark:hover:text-white border border-regular dark:border-box-dark-up text-[13px] font-normal capitalize text-[rgb(64_64_64_/_var(--tw-text-opacity))] duration ease-in-out border-solid hover:bg-primary hover:text-white cursor-pointer" href="#" aria-label="Next" data-paginate="${nextPage}">
                <i class="uil uil-angle-right text-[16px]"></i>
            </a>
        </li>`;

    // Combine and set pagination bar content
    let template = `
        <nav aria-label="Page navigation example">
            <ul class="flex items-center justify-center gap-2 list-style-none listItemActive">
                ${paginationItems}
            </ul>
        </nav>`;

    paginationBar.innerHTML = template;

    // Add event listeners for page navigation
    const pageLinks = paginationBar.querySelectorAll('a[data-paginate]');
    pageLinks.forEach(link => {
      link.addEventListener('click', (event) => {
        event.preventDefault();
        const page = parseInt((event.currentTarget as HTMLElement).getAttribute('data-paginate')!);
        this.goToPage(page);
      });
    });
  }
}
