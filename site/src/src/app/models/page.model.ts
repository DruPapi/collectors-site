export class Page implements PageInterface {
    constructor(
        public pageNumber: number,
        public label: string | number,
        public active: boolean,
    ) {}
}

export interface PageInterface {
    pageNumber: number;
    label: string | number;
    active: boolean;
}
