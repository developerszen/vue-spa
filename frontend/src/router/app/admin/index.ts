import { home } from "@/router/app/admin/home";
import { author } from "@/router/app/admin/author";
import { book } from "@/router/app/admin/book";

export const admin = [...home, ...author, ...book];
