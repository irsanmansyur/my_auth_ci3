import { atom } from "recoil";

export const settingsState = atom({
  key: 'setting',
  default: {},
});

export const userState = atom({
  key: 'user',
  default: {},
});
export const detailModal = atom({
  key: 'detailModal',
  default: false,
});