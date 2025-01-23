import {CollectibleItem} from "./collectible.model";

export interface CartI {
    items: Array<CartItem>;
    getAllValue(): number;
    getAllQuantity(): number;
}

export class Cart implements CartI {
    constructor(public items: Array<CartItem>) {}

    getAllValue(): number {
        return this.items.reduce(
            (acc, item) => acc + item.quantity * item.collectible.value,
            0
        );
    }

    getAllQuantity(): number {
        return this.items.reduce((acc, item) => acc + item.quantity, 0);
    }
}

export interface CartItem {
    id: number;
    quantity: number;
    collectible: CollectibleItem;
}
