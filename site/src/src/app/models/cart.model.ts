import {CollectibleItem} from "./collectible.model";

export interface Cart {
    items: Array<CartItem>;
}
export interface CartItem {
    id: number;
    quantity: number;
    collectible: CollectibleItem;
}
