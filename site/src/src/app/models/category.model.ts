export interface Categories {
    items: Array<CategoryItem>;
}
export interface CategoryItem {
    id: number;
    name: string;
    collectibles_count: number;
}
