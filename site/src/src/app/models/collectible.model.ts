export interface Collectibles {
    items: Array<CollectibleItem>;
    max_page: number;
    current_page: number;
}
export interface Collectible {
    item: CollectibleItem;
    previous: CollectibleSibling | null;
    next: CollectibleSibling | null;
}
export interface CollectibleItem {
    id: number;
    name: string;
    file_name: string;
    value: number;
    in_cart: boolean;
    type: string;
}
export interface CollectibleSibling {
    id: number;
    name: string;
    file_name: string;
}
