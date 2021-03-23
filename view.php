CREATE OR REPLACE VIEW vpeminjaman as
SELECT distinct peminjaman_detil.kd_buku, buku.judul, count(peminjaman_detil.kd_buku) as 'jlh_peminjaman'
FROM peminjaman_detil, buku, peminjaman
WHERE peminjaman_detil.kd_buku=buku.kd_buku AND peminjaman.no_pinjam = peminjaman_detil.no_pinjam AND peminjaman.status = "Pinjam"
GROUP BY peminjaman_detil.kd_buku;

CREATE OR REPLACE VIEW vstokbuku as
SELECT distinct peminjaman_detil.kd_buku, buku.judul, pengadaan.jumlah-vpeminjaman.jlh_peminjaman as stok
FROM peminjaman_detil, pengadaan, vpeminjaman, buku, peminjaman
WHERE peminjaman_detil.kd_buku=pengadaan.kd_buku AND peminjaman_detil.kd_buku=buku.kd_buku AND peminjaman.no_pinjam = peminjaman_detil.no_pinjam AND peminjaman.status = "Pinjam"
GROUP BY peminjaman_detil.kd_buku;

CREATE OR REPLACE VIEW vlapbln as
SELECT peminjaman_detil.no_pinjam, peminjaman.tgl_pinjam, peminjaman.nisn AS nim, mahasiswa.nm_mahasiswa, buku.judul, peminjaman.status
FROM peminjaman, mahasiswa, peminjaman_detil, buku WHERE peminjaman.nisn = mahasiswa.nim AND peminjaman_detil.no_pinjam=peminjaman.no_pinjam AND peminjaman_detil.kd_buku = buku.kd_buku ORDER BY peminjaman.no_pinjam desc;

CREATE OR REPLACE VIEW vlapsiswa as
SELECT peminjaman_detil.no_pinjam, peminjaman.tgl_pinjam, peminjaman.tgl_kembali, peminjaman.nisn AS nim, mahasiswa.nm_mahasiswa, buku.judul, peminjaman.username, peminjaman.status
FROM peminjaman, peminjaman_detil, mahasiswa, buku 
WHERE peminjaman.nisn = mahasiswa.nim AND peminjaman.no_pinjam=peminjaman_detil.no_pinjam AND peminjaman_detil.kd_buku = buku.kd_buku
ORDER BY peminjaman_detil.no_pinjam ASC;

DELIMITER !
CREATE OR REPLACE TRIGGER hapus_kategori
AFTER DELETE on kategori
FOR EACH ROW
BEGIN
DELETE FROM buku WHERE kd_kategori = OLD.kd_kategori;
END;
!

DELIMITER !
CREATE OR REPLACE TRIGGER hapus_pengadaan
AFTER DELETE on pengadaan
FOR EACH ROW
BEGIN
DELETE FROM buku WHERE kd_buku = OLD.kd_buku;
END;
!

DELIMITER !
CREATE OR REPLACE TRIGGER hapus_penerbit
AFTER DELETE on penerbit
FOR EACH ROW
BEGIN
DELETE FROM buku WHERE kd_penerbit = OLD.kd_penerbit;
END;
!

//log
DELIMITER !
CREATE OR REPLACE TRIGGER insert_buku_log
AFTER INSERT on buku
FOR EACH ROW
BEGIN
INSERT INTO log VALUES (NULL,new.username,now(),new.judul,'INSERT');
END;
!

DELIMITER !
CREATE OR REPLACE TRIGGER hapus_buku_log
AFTER DELETE on buku
FOR EACH ROW
BEGIN
INSERT INTO log VALUES (NULL,OLD.username,now(),OLD.judul,'DELETE');
END;
!

DELIMITER !
CREATE OR REPLACE TRIGGER update_buku_log
AFTER UPDATE on buku
FOR EACH ROW
BEGIN
INSERT INTO log VALUES (NULL,NEW.username,now(),NEW.judul,'UPDATE');
END;
!

//privileges
GRANT ALL PRIVILEGES ON *.* to febria@localhost identified by 'riri' with grant option;
GRANT USAGE ON *.* to dhita@localhost identified by 'dhita';
GRANT SELECT ON perpustakaan.* to dhita@localhost;
GRANT USAGE ON *.* to romzi@localhost identified by 'romzi';
GRANT SELECT,INSERT ON perpustakaan.* to romzi@localhost;
GRANT USAGE ON *.* to pika@localhost identified by 'pika';
GRANT INSERT,UPDATE ON perpustakaan.* to pika@localhost;