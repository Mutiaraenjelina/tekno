# Efran Core Ownership

Bagian ini khusus untuk Efran: CRUD dan logic sistem inti.

## Scope Efran

- Auth: register, login, logout
- Tagihan: CRUD tagihan
- Pelanggan: CRUD pelanggan
- Tagihan User: relasi tagihan ke user
- Dashboard: total tagihan, total bayar, total belum bayar
- Input manual cash: tandai pembayaran selesai
- API internal untuk Mutiara

## Scope Mutiara

- Setup Midtrans
- Install SDK dan set server key
- Create payment dummy dulu
- Payment page / tombol bayar
- Callback pembayaran

## Modul Sistem

- Auth
- Tagihan (Billing)
- User/Pelanggan
- Transaksi
- Payment Gateway (Midtrans)

## Kontrak data wajib disamakan

Payload inti yang dipakai lintas modul:

```json
{
  "tagihan_id": 1,
  "user_id": 2,
  "amount": 50000
}
```

## Field penting

Tagihan:

- `id`
- `nama_tagihan`
- `deskripsi`
- `nominal`
- `tipe`
- `jatuh_tempo`
- `created_by`

Pelanggan:

- `id`
- `nama`
- `no_wa`

Tagihan user:

- `id`
- `tagihan_id`
- `user_id`
- `status`
- `payment_id`

Payment log:

- `id`
- `order_id`
- `status`
- `amount`
- `metode`

## API utama (MVP)

Base path: `/api`

- `POST /register`
- `POST /login`
- `POST /logout`
- `GET /tagihan/{id}`
- `POST /tagihan`
- `POST /pelanggan`
- `POST /tagihan-user`
- `POST /create-payment`
- `POST /transaksi`
- `PUT /transaksi/status`
- `POST /manual-cash`
- `POST /midtrans-callback`

Catatan integrasi:

- `POST /create-payment` menerima payload inti (`tagihan_id`, `user_id`, `amount`) dan membuat transaksi `pending`.
- `POST /transaksi` menerima payload inti yang sama; field lain opsional (`metode`, `status`, `order_id`).
- `PUT /transaksi/status` mendukung:
  - `order_id + status`, atau
  - `tagihan_id + user_id + status`.
- `GET /tagihan/{id}` dipakai untuk detail tagihan dan assignment user.

## Prioritas kerja

Minggu awal:

- Efran: Auth, Tagihan, Pelanggan
- Mutiara: setup Midtrans, create payment dummy

Setelah itu:

- Integrasi endpoint pembayaran, callback, dan payment page

## Target MVP

Kalau ini jalan:

- Buat tagihan
- User bayar
- Status berubah
