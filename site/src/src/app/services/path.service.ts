import { Injectable } from '@angular/core';
import { CollectibleItem, CollectibleSibling } from "../models/collectible.model";

@Injectable({
  providedIn: 'root'
})
export class PathService {
  collectibleViewPath(collectible: CollectibleItem | CollectibleSibling, categoryId: number | null): string {
    let path = "/szalvetak/";

    path += collectible.id;
    if (categoryId) {
      path += "?category_id=" + categoryId;
    }

    return path;
  }

  imagePath(collectible: CollectibleItem | CollectibleSibling): string {
    return '/assets/images/' + collectible.file_name;
  }

  thumbnailPath(collectible: CollectibleItem | CollectibleSibling): string {
    return '/assets/images/mini/TN_' + collectible.file_name;
  }
}
