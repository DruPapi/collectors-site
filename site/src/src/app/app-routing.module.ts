import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HomeComponent } from './pages/home/home.component';
import { CollectibleComponent } from "./pages/collectible/collectible.component";
import { CollectiblesComponent } from "./pages/collectible/collectibles.component";

const routes: Routes = [
  {
    path:'',
    component:HomeComponent
  },
  {
    path:'home',
    component:HomeComponent
  },
  {
    path:'szalvetak',
    component: CollectiblesComponent
  },
  {
    path:'szalvetak/:id',
    component: CollectibleComponent
  },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
