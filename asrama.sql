/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     24/10/2024 02:43:26                          */
/*==============================================================*/


alter table absensi 
   drop foreign key fk_absensi_relations_pengurus;

alter table absensi 
   drop foreign key fk_absensi_relations_warga;

alter table absensi 
   drop foreign key fk_absensi_relations_kegiatan;

alter table absensi 
   drop foreign key fk_absensi_relations_extrakul;

alter table formulir_kegiatan 
   drop foreign key fk_formulir_relations_kegiatan;

alter table formulir_kegiatan 
   drop foreign key fk_formulir_relations_warga;

alter table formulir_kepuasan 
   drop foreign key fk_formulir_relations_warga;

alter table pendaftaran 
   drop foreign key fk_pendafta_relations_warga;

alter table spk 
   drop foreign key fk_spk_relations_warga;

alter table warga 
   drop foreign key fk_warga_relations_pengurus;

alter table warga 
   drop foreign key fk_warga_relations_extrakul;


alter table absensi 
   drop foreign key fk_absensi_relations_warga;

alter table absensi 
   drop foreign key fk_absensi_relations_kegiatan;

alter table absensi 
   drop foreign key fk_absensi_relations_extrakul;

alter table absensi 
   drop foreign key fk_absensi_relations_pengurus;

drop table if exists absensi;

drop table if exists extrakulikuler;


alter table formulir_kegiatan 
   drop foreign key fk_formulir_relations_warga;

alter table formulir_kegiatan 
   drop foreign key fk_formulir_relations_kegiatan;

drop table if exists formulir_kegiatan;


alter table formulir_kepuasan 
   drop foreign key fk_formulir_relations_warga;

drop table if exists formulir_kepuasan;

drop table if exists kegiatan;


alter table pendaftaran 
   drop foreign key fk_pendafta_relations_warga;

drop table if exists pendaftaran;

drop table if exists pengurus;


alter table spk 
   drop foreign key fk_spk_relations_warga;

drop table if exists spk;


alter table warga 
   drop foreign key fk_warga_relations_extrakul;

alter table warga 
   drop foreign key fk_warga_relations_pengurus;

drop table if exists warga;

/*==============================================================*/
/* Table: absensi                                               */
/*==============================================================*/
create table absensi
(
   id_absen             int not null  comment '',
   id_kegiatan          int  comment '',
   nim                  varchar(12)  comment '',
   id_extra             int  comment '',
   nim_pengurus         varchar(12)  comment '',
   status_kehadiran     varchar(255)  comment '',
   waktu_absen          timestamp  comment '',
   jenis_absen          varchar(12)  comment '',
   keterangan           varchar(255)  comment '',
   primary key (id_absen)
);

/*==============================================================*/
/* Table: extrakulikuler                                        */
/*==============================================================*/
create table extrakulikuler
(
   id_extra             int not null  comment '',
   nama_extra           varchar(255)  comment '',
   deskripsi_extra      longtext  comment '',
   gambar_pamflet       varchar(255)  comment '',
   jadwal               varchar(25)  comment '',
   kuota                int  comment '',
   primary key (id_extra)
);

/*==============================================================*/
/* Table: formulir_kegiatan                                     */
/*==============================================================*/
create table formulir_kegiatan
(
   id_formulir_kegiatan int not null  comment '',
   id_kegiatan          int  comment '',
   nim                  varchar(12)  comment '',
   pertanyaan1          varchar(255)  comment '',
   pertanyaan2          varchar(255)  comment '',
   pertanyaan3          varchar(255)  comment '',
   pertanyaan4          varchar(255)  comment '',
   pertanyaan5          varchar(255)  comment '',
   saran_masukan        longtext  comment '',
   primary key (id_formulir_kegiatan)
);

/*==============================================================*/
/* Table: formulir_kepuasan                                     */
/*==============================================================*/
create table formulir_kepuasan
(
   id_formulir          int not null  comment '',
   nim                  varchar(12)  comment '',
   pesan                text  comment '',
   created_at           timestamp  comment '',
   kategori             varchar(255)  comment '',
   primary key (id_formulir)
);

/*==============================================================*/
/* Table: kegiatan                                              */
/*==============================================================*/
create table kegiatan
(
   nama_kegiatan        varchar(255)  comment '',
   id_kegiatan          int not null  comment '',
   tanggal_kegiatan     datetime  comment '',
   created_at           timestamp  comment '',
   deskripsi            longtext  comment '',
   foto_pamflet         varchar(255)  comment '',
   tempat               varchar(255)  comment '',
   primary key (id_kegiatan)
);

/*==============================================================*/
/* Table: pendaftaran                                           */
/*==============================================================*/
create table pendaftaran
(
   id                   varchar(12) not null  comment '',
   nim                  varchar(12)  comment '',
   nama_lengkap         varchar(255)  comment '',
   prodi_pendaftar      varchar(255)  comment '',
   foto_pendaftar       varchar(255)  comment '',
   alamat_pendaftar     varchar(255)  comment '',
   ttl                  varchar(255)  comment '',
   no_hp_pendaftar      varchar(12)  comment '',
   email_pendaftar      varchar(255)  comment '',
   created_at_pendaftar timestamp  comment '',
   nomor_pendaftaran    varchar(255)  comment '',
   jenis_kelamin        varchar(12)  comment '',
   jalur_masuk          varchar(255)  comment '',
   foto_bukti_lolos_ptn varchar(255)  comment '',
   nama_ayah            varchar(255)  comment '',
   nama_ibu             varchar(255)  comment '',
   no_hp_ortu           varchar(255)  comment '',
   primary key (id)
);

/*==============================================================*/
/* Table: pengurus                                              */
/*==============================================================*/
create table pengurus
(
   nama_pengurus        varchar(255)  comment '',
   nim_pengurus         varchar(12) not null  comment '',
   kamar_pengurus       varchar(12)  comment '',
   gedung_pengurus      varchar(12)  comment '',
   no_hp_pengurus       varchar(12)  comment '',
   password_pengurus    varchar(255)  comment '',
   email_pengurus       varchar(255)  comment '',
   divisi_pengurus      varchar(255)  comment '',
   jabatan_pengurus     varchar(255)  comment '',
   foto_pengurus        varchar(255)  comment '',
   prodi_pengurus       varchar(255)  comment '',
   jenis_kelamin_pengurus varchar(12)  comment '',
   primary key (nim_pengurus)
);

/*==============================================================*/
/* Table: spk                                                   */
/*==============================================================*/
create table spk
(
   id_spk               int not null  comment '',
   nim                  varchar(12)  comment '',
   score                float  comment '',
   status               varchar(255)  comment '',
   keterangan           varchar(255)  comment '',
   primary key (id_spk)
);

/*==============================================================*/
/* Table: warga                                                 */
/*==============================================================*/
create table warga
(
   nim                  varchar(12) not null  comment '',
   id_extra             int  comment '',
   nim_pengurus         varchar(12)  comment '',
   nama                 varchar(255)  comment '',
   no_hp                varchar(12)  comment '',
   password             varchar(255)  comment '',
   kamar                varchar(12)  comment '',
   foto_warga           varchar(255)  comment '',
   email                varchar(255)  comment '',
   gedung               varchar(12)  comment '',
   prodi                varchar(255)  comment '',
   primary key (nim)
);

alter table absensi add constraint fk_absensi_relations_pengurus foreign key (nim_pengurus)
      references pengurus (nim_pengurus) on delete restrict on update restrict;

alter table absensi add constraint fk_absensi_relations_warga foreign key (nim)
      references warga (nim) on delete restrict on update restrict;

alter table absensi add constraint fk_absensi_relations_kegiatan foreign key (id_kegiatan)
      references kegiatan (id_kegiatan) on delete restrict on update restrict;

alter table absensi add constraint fk_absensi_relations_extrakul foreign key (id_extra)
      references extrakulikuler (id_extra) on delete restrict on update restrict;

alter table formulir_kegiatan add constraint fk_formulir_relations_kegiatan foreign key (id_kegiatan)
      references kegiatan (id_kegiatan) on delete restrict on update restrict;

alter table formulir_kegiatan add constraint fk_formulir_relations_warga foreign key (nim)
      references warga (nim) on delete restrict on update restrict;

alter table formulir_kepuasan add constraint fk_formulir_relations_warga foreign key (nim)
      references warga (nim) on delete restrict on update restrict;

alter table pendaftaran add constraint fk_pendafta_relations_warga foreign key (nim)
      references warga (nim) on delete restrict on update restrict;

alter table spk add constraint fk_spk_relations_warga foreign key (nim)
      references warga (nim) on delete restrict on update restrict;

alter table warga add constraint fk_warga_relations_pengurus foreign key (nim_pengurus)
      references pengurus (nim_pengurus) on delete restrict on update restrict;

alter table warga add constraint fk_warga_relations_extrakul foreign key (id_extra)
      references extrakulikuler (id_extra) on delete restrict on update restrict;

