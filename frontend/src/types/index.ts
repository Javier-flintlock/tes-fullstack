export interface Anggota {
    id: number
    name: string
    email: string
    jabatan: string
    department: string
    password: string
}

export interface Inventaris {
    id: number
    inventaris_id: string
    barang: string
    type: string
    serial_number: any
    spesifikasi: string
    status: string
    assign: any
    department: string
    user: any
}