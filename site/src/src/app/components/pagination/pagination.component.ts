import { Component, Input, OnInit } from '@angular/core';
import { PathService } from "../../services/path.service";
import { Page } from "../../models/page.model";

@Component({
    selector: 'app-pagination',
    templateUrl: './pagination.component.html',
    styleUrls: ['./pagination.component.scss'],
})
export class PaginationComponent implements OnInit {
    @Input() currentPage: number = 1;
    @Input() maxPage: number | null = null;
    @Input() categoryId: number | null = null;
    @Input() displayNumberOfPages: number = 7;
    pages: Page[] = [];

    constructor(
        public path: PathService,
    ) {}

    ngOnInit(): void {
        this.currentPage = +this.currentPage;
        this.generatePageList();
    }

    // based on [ngx-pagination](https://github.com/michaelbromley/ngx-pagination/blob/master/projects/ngx-pagination/src/lib/pagination-controls.directive.ts)
    private generatePageList(): void {

        this.pages = [];
        if (this.maxPage === null) {
            return;
        }
        if (this.hasPrevious()) {
            this.pages.push(new Page(this.currentPage - 1, '<', false));
        }

        const isStart = this.currentPage <= Math.floor(this.displayNumberOfPages / 2);
        const isEnd = this.maxPage - Math.floor(this.displayNumberOfPages / 2) < this.currentPage;
        const isMiddle = !isStart && !isEnd;

        let ellipsesNeeded = this.displayNumberOfPages < this.maxPage;
        let i = 1;

        while (i <= this.maxPage && i <= this.displayNumberOfPages) {
            let label;
            let pageNumber = this.calculatePageNumber(i, this.currentPage, this.displayNumberOfPages, this.maxPage);
            let openingEllipsesNeeded = (i === 2 && (isMiddle || isEnd));
            let closingEllipsesNeeded = (i === this.displayNumberOfPages - 1 && (isMiddle || isStart));
            if (ellipsesNeeded && (openingEllipsesNeeded || closingEllipsesNeeded)) {
                label = '...';
            } else {
                label = pageNumber;
            }
            this.pages.push(new Page(pageNumber, label, pageNumber === this.currentPage));
            i++;
        }

        if (this.hasNext()) {
            this.pages.push(new Page(this.currentPage + 1, '>', false));
        }
    }

    private hasPrevious(): boolean {
        return this.currentPage > 1;
    }

    private hasNext(): boolean {
        if (this.maxPage === null) {
            return false;
        }

        return this.currentPage < this.maxPage;
    }

    private calculatePageNumber(i: number, currentPage: number, paginationRange: number, totalPages: number) {
        let halfWay = Math.ceil(paginationRange / 2);
        if (i === paginationRange) {
            return totalPages;
        }
        if (i === 1 || paginationRange >= totalPages) {
            return i;
        }
        if (totalPages - halfWay < currentPage) {
            return totalPages - paginationRange + i;
        }
        if (halfWay < currentPage) {
            return currentPage - halfWay + i;
        }
        return i;
    }
}
