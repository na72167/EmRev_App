# Entity Layout

<!-- TOC -->
<!-- HTMLファイルのID属性に沿って移動させている。 -->

- [Entity Layout](#db-entity-layout)
    - [Overview](#overview)
    - [Transaction tables](#transaction-tables)
        - [オーダーテーブル t_orders ](#torders)

<!-- /TOC -->

## Overview
- 本ドキュメントは、DB の Entity Layout について記載する。

## Transaction tables
- トランザクションテーブルのレイアウトは以下の通りとなる。
    - テーブル名の prefix に　`t_` をつける。

### E-R diagram

<!--  Layout settings  色や隠す関係のメソッドを設定している。 -->
<!-- !define・・・定数内はnot nullである事を宣言している。 -->

<!-- Table description [e-r図関係] -->

```uml
@startuml

''''''''''''''''''''''''''''''''''
' Layout settings                '
''''''''''''''''''''''''''''''''''

hide methods
hide stereotypes
!define MAIN_ENTITY #E2EFDA-C6E0B4
!define MAIN_ENTITY_NEW #FCE4D6-F8CBAD
!define METAL #F2F2F2-D9D9D9
!define MASTER_MARK_COLOR AAFFAA
!define TRANSACTION_MARK_COLOR FFAA00
skinparam class {
    BackgroundColor METAL
    BorderColor Black
    ArrowColor Black
}
!define table(x) class x << (T,#FFAAAA) >>
!define primary_key(x) <color:red>x</color>
!define foreign_key(x) <color:blue>x</color>
!define unique(x) <color:green>x</color>

'''''''''''''''''''''''''
' Table description     '
'''''''''''''''''''''''''


'''''''''''''''''''''''
' Relation definition '
'''''''''''''''''''''''

@enduml
```

```uml
@startuml

''''''''''''''''''''''''''''''''''
' Layout settings                '
''''''''''''''''''''''''''''''''''
hide methods
hide stereotypes
!define MAIN_ENTITY #E2EFDA-C6E0B4
!define MAIN_ENTITY_NEW #FCE4D6-F8CBAD
!define METAL #F2F2F2-D9D9D9
!define MASTER_MARK_COLOR AAFFAA
!define TRANSACTION_MARK_COLOR FFAA00
skinparam class {
    BackgroundColor METAL
    BorderColor Black
    ArrowColor Black
}
!define table(x) class x << (T,#FFAAAA) >>
!define primary_key(x) <color:red>x</color>
!define foreign_key(x) <color:blue>x</color>
!define unique(x) <color:green>x</color>


'''''''''''''''''''''''''
' Table description     '
'''''''''''''''''''''''''

@enduml
```
company_informations
- 緑はトランザクションテーブル。赤は中間テーブル。

### users
- users (ユーザー情報の管理)

- N/A・・・該当なし
- 同じテーブル内でデータの出し入れがあった際にNullable or NOT NULLの判定が走っているのかを確認。

| Field                 | Type          |Collation             |Nullable or NOT NULL  | Key    | Default           | Extra          |Description                                  |
|:----------------------|:--------------|:---------------------|:---------------------|:-------|:------------------|:---------------|:---------------------------------------------|
| id                    | int(11)       |                      | NOT NULL              | UNIQUE | N/A               | auto_increment |                                              |
| email                 | varchar(255)  |utf8_general_ci       | NOT NULL              | UNIQUE | N/A               |                |                                              |
| password              | varchar(255)  |utf8_general_ci       | NOT NULL              |        | N/A               |                |                                              |
| roll                  | int(11)       |                      | NOT NULL              |        | 100               |                | value内に入る数字の役割は-rollへ                 |
| report_flg            | tinyint(1)    |                      | NOT NULL              |        | N/A               |                | 通報フラグ                                     |
| remember_token        |               |                      |                       |        |                   |                | 検討項目                                      |
| delete_flg            | tinyint(1)    |                      | NOT NULL              |        | 0                 |                |                                              |
| create_date           | datetime      |                      | NOT NULL              |        | N/A               |                |                                              |
| update_date           | timestamp     |                      | NOT NULL              |        | CURRENT_TIMESTAMP |                |                                              |

- roll

| Value | Description |
|:------|:------------|
| 1     | 管理者       |
| 50    | 社員        |
| 100   | 一般        |
| 150   | 退会済        |


### general_profs
- general_profs(一般ユーザーのプロフィール情報の管理)
  - users:general_profsは1:1の関係となる

| Field                 | Type          |Collation             |Nullable or NOT NULL  | Key    | Default           | Extra          | Description                                  |
|:----------------------|:--------------|:---------------------|:---------------------|:-------|:------------------|:---------------|:---------------------------------------------|
| id                    | int(11)       |                      | NOT NULL             | UNIQUE | N/A               | auto_increment |                                              |
| user_id               | int(11)       |                      | NOT NULL             | UNIQUE | N/A               |                |                                              |
| username              | varchar(255)  |utf8_general_ci       | NOT NULL             |        | N/A               |                |                                              |
| age                   | int(11)       |                      | NOT NULL             |        | N/A               |                |                                              |
| tel                   | int(11)       |                      | NOT NULL             |        | N/A               |                |                                              |
| zip                   | int(11)       |                      | NOT NULL             |        | N/A               |                |                                              |
| addr                  | varchar(255)  |utf8_general_ci       | NOT NULL             |        | N/A               |                |                                              |
| delete_flg            | tinyint(1)    |                      | NOT NULL             |        | 0                 |                |                                              |
| create_date           | datetime      |                      | NOT NULL             |        | N/A               |                |                                              |
| update_date           | timestamp     |                      | NOT NULL             |        | CURRENT_TIMESTAMP |                |                                              |


- **Relationship**



### employee_profs
- 会社員プロフと一般プロフは分けたいと考える人もいるかもしれないので中間テーブルでの管理はしない。
- employee_profs (会社員側プロフィール情報の管理)
    - general_profs:employee_profsは1:1の関係となる
    - users:employee_profsは1:1の関係となる

| Field                 | Type          |Collation             |Nullable or NOT NULL  | Key    | Default           | Extra          | Description                                  |
|:----------------------|:--------------|:---------------------|:---------------------|:-------|:------------------|:---------------|:---------------------------------------------|
| id                    | int(11)       |                      | NOT NULL             | UNIQUE | N/A               | auto_increment |                                              |
| general_id            | int(11)       |                      | NOT NULL             | UNIQUE | N/A               |                |                                              |
| user_id               | int(11)       |                      | NOT NULL             | UNIQUE | N/A               |                |                                              |
| username              | varchar(255)  |utf8_general_ci       | NOT NULL             |        | N/A               |                |                                              |
| age                   | int(11)       |                      | NOT NULL             |        | N/A               |                |                                              |
| tel                   | int(11)       |                      | NOT NULL             |        | N/A               |                |                                              |
| zip                   | int(11)       |                      | NOT NULL             |        | N/A               |                |                                              |
| addr                  | varchar(255)  |utf8_general_ci       | NOT NULL             |        | N/A               |                |                                              |
| affiliation_company   | varchar(255)  |utf8_general_ci       | NOT NULL             |        | N/A               |                |現所属会社                                      |
| incumbent             | varchar(255)  |utf8_general_ci       | NOT NULL             |        | N/A               |                |現職                                           |
| currently_department  | varchar(255)  |utf8_general_ci       | NOT NULL             |        | N/A               |                |現部署                                         |
| currently_position    | varchar(255)  |utf8_general_ci       | NOT NULL             |        | N/A               |                |現役職                                         |
| dm_state              | tinyint(1)    |                      | NOT NULL             |        | N/A               |                |DM可否                                         |
| delete_flg            | tinyint(1)    |                      | NOT NULL             |        | N/A               |                |                                              |
| create_date           | datetime      |                      | NOT NULL             |        | N/A               |                |                                              |
| update_date           | timestamp     |                      | NOT NULL             |        | CURRENT_TIMESTAMP |                |                                              |


- **Relationship**




### employee_reviews
- employee_reviews(社員のレビュー内容の管理)
    - employee_profs:employee_reviewsは1:nの関係となる。
    - employee_reviews:review_company_idは1:1の関係となる。

| Field                       | Type          |Collation             |Nullable or NOT NULL  | Key    | Default           | Extra          | Description                                  |
|:----------------------------|:--------------|:---------------------|:---------------------|:-------|:------------------|:---------------|:---------------------------------------------|
| id                          | int(11)       |                      | NOT NULL             | UNIQUE | N/A               | auto_increment |                                              |
| employee_id                 | int(11)       |                      | NOT NULL             |        | N/A               |                |                                              |
| review_company_id           | int(11)       |                      | NOT NULL             |        | N/A               |                |                                              |
| joining route               | varchar(255)  | utf8_general_ci      | Nullable             |        | N/A               |                |入社経路                                       |
| occupation                  | varchar(255)  | utf8_general_ci      | Nullable             |        | N/A               |                |在籍時の職種                                    |
| position                    | varchar(255)  | utf8_general_ci      | Nullable             |        | N/A               |                |在籍時の役職                                    |
| enrollment_period           | varchar(255)  | utf8_general_ci      | Nullable             |        | N/A               |                |在籍期間                                       |
| enrollment_status           | varchar(255)  | utf8_general_ci      | Nullable             |        | N/A               |                |在籍状況                                       |
| employment_status           | varchar(255)  | utf8_general_ci      | Nullable             |        | N/A               |                |雇用形態                                       |
| welfare_office_environment  | varchar(255)  | utf8_general_ci      | Nullable             |        | N/A               |                |福利厚生・オフィス環境                           |
| working_hours               | int(11)       |                      | Nullable             |        | N/A               |                |勤務時間                                       |
| holiday                     | varchar(255)  | utf8_general_ci      | Nullable             |        | N/A               |                |休日                                          |
| in_company_system           | varchar(255)  | utf8_general_ci      | Nullable             |        | N/A               |                |社内制度                                       |
| corporate_culture           | varchar(255)  | utf8_general_ci      | Nullable             |        | N/A               |                |企業文化                                       |
| organizational_structure    | varchar(255)  | utf8_general_ci      | Nullable             |        | N/A               |                |組織体制                                       |
| ease_of_work_for_women      | varchar(255)  | utf8_general_ci      | Nullable             |        | N/A               |                |女性の働きやすさ                                |
| rewarding_work              | varchar(255)  | utf8_general_ci      | Nullable             |        | N/A               |                |働きがい                                       |
| image_gap                   | varchar(255)  | utf8_general_ci      | Nullable             |        | N/A               |                |入社前とのギャップ                               |
| business_outlook            | varchar(255)  | utf8_general_ci      | Nullable             |        | N/A               |                |事業展望                                       |
| strengths_and_weaknesses    | varchar(255)  | utf8_general_ci      | Nullable             |        | N/A               |                |強み・弱み                                     |
| annual_income_salary        | varchar(255)  | utf8_general_ci      | Nullable             |        | N/A               |                |年収・給与                                     |
| general_estimation          | varchar(255)  | utf8_general_ci      | Nullable             |        | N/A               |                |総評　　　                                     |
| like_count                  | int(11)       |                      | NOT NULL             |        | 0                 |                |レビュー毎のいいね数をカウントする                 |
| delete_flg                  | tinyint(1)    |                      | NOT NULL             |        | N/A               |                |                                              |
| create_date                 | datetime      |                      | NOT NULL             |        | N/A               |                |                                              |
| update_date                 | timestamp     |                      | NOT NULL             |        | CURRENT_TIMESTAMP |                |                                              |



- **Relationship**




### dm_messages
- dm_messages(ダイレクトメッセージ情報を管理するテーブル)
 - DM機能をもう一度洗い直してテーブルを考える。

| Field                       | Type          |Collation             |Nullable or NOT NULL  | Key    | Default           | Extra          | Description                                  |
|:----------------------------|:--------------|:---------------------|:---------------------|:-------|:------------------|:---------------|:---------------------------------------------|
| id                          | int(11)       |                      | NOT NULL             | UNIQUE | N/A               | auto_increment |                                              |
| send_date                   | datetime      |                      | NOT NULL             |        | N/A               |                |                                              |
| to_user                     | int(11)       |                      | NOT NULL             |        | N/A               |                |DMを送る側のユーザー情報                         |
| from_user                   | int(11)       |                      | NOT NULL             |        | N/A               |                |DMを受け取る側のユーザー情報                      |
| msg                         | varchar(255)  | utf8_general_ci      | NOT NULL             |        | N/A               |                |                                              |
| delete_flg                  | tinyint(1)    |                      | NOT NULL             |        | N/A               |                |                                              |
| create_date                 | datetime      |                      | NOT NULL             |        | N/A               |                |                                              |
| update_date                 | timestamp     |                      | NOT NULL             |        | CURRENT_TIMESTAMP |                |                                              |




- **Relationship**

| Column name        | Target table name | Target column name | CASCADE           |
|:-------------------|:------------------|:-------------------|:------------------|
| t_delivery_plan_id | t_delivery_plans  | id                 | ON DELETE CASCADE |



### public_messages
- public_messages(パブリックメッセージを管理するテーブル)
 - pm機能をもう一度洗い直してテーブルを考える。

| Field                       | Type          |Collation             |Nullable or NOT NULL  | Key    | Default           | Extra          | Description                                  |
|:----------------------------|:--------------|:---------------------|:---------------------|:-------|:------------------|:---------------|:---------------------------------------------|
| id                          | int(11)       |                      | NOT NULL             | UNIQUE | N/A               | auto_increment |                                              |
| send_date                   | datetime      |                      | NOT NULL             |        | N/A               |                |                                              |
| to_user                     | int(11)       |                      | NOT NULL             |        | N/A               |                |DMを送る側のユーザー情報                         |
| from_user                   | int(11)       |                      | NOT NULL             |        | N/A               |                |DMを受け取る側のユーザー情報                      |
| msg                         | varchar(255)  | utf8_general_ci      | NOT NULL             |        | N/A               |                |                                              |
| delete_flg                  | tinyint(1)    |                      | NOT NULL             |        | N/A               |                |                                              |
| create_date                 | datetime      |                      | NOT NULL             |        | N/A               |                |                                              |
| update_date                 | timestamp     |                      | NOT NULL             |        | CURRENT_TIMESTAMP |                |                                              |

- **Relationship**

| Column name               | Target table name       | Target column name | CASCADE                             |
|:--------------------------|:------------------------|:-------------------|:------------------------------------|
| t_order_attribute_id      | t_order_attributes      | id                 | ON UPDATE CASCADE,ON DELETE CASCADE |
| t_delivery_plan_detail_id | t_delivery_plan_details | id                 | ON UPDATE CASCADE,ON DELETE CASCADE |



### review_likes
- review_likes (レビューのお気に入り登録用のテーブル)
  - users:review_likesは1:1の関係となる
  - review_likes:employee_reviewsは1:nの関係となる

| Field                       | Type          |Collation             |Nullable or NOT NULL  | Key    | Default           | Extra          | Description                                  |
|:----------------------------|:--------------|:---------------------|:---------------------|:-------|:------------------|:---------------|:---------------------------------------------|
| id                          | int(11)       |                      | NOT NULL             | UNIQUE | N/A               | auto_increment |                                              |
| employee_review_id          | int(11)       |                      | NOT NULL             |        | N/A               |                |                                              |
| user_id                     | int(11)       |                      | NOT NULL             |        | N/A               |                |                                              |
| delete_flg                  | tinyint(1)    |                      | NOT NULL             |        | N/A               |                |                                              |
| create_date                 | datetime      |                      | NOT NULL             |        | N/A               |                |                                              |
| update_date                 | timestamp     |                      | NOT NULL             |        | CURRENT_TIMESTAMP |                |                                              |


- **Relationship**

| Column name               | Target table name       | Target column name | CASCADE           |
|:--------------------------|:------------------------|:-------------------|:------------------|
| t_delivery_plan_detail_id | t_delivery_plan_details | id                 | ON DELETE CASCADE |



### company_informations
- company_informations（会社情報管理テーブル）
 - company_informations:employee_reviewsは1:nの関係となる

| Field                       | Type          |Collation             |Nullable or NOT NULL  | Key    | Default           | Extra          | Description                                  |
|:----------------------------|:--------------|:---------------------|:---------------------|:-------|:------------------|:---------------|:---------------------------------------------|
| id                          | int(11)       |                      | NOT NULL             | UNIQUE | N/A               | auto_increment |                                              |
| employee_reviews_id         | int(11)       |                      | NOT NULL             |        | N/A               |                |                                              |
| company_name                | varchar(255)  | utf8_general_ci      | NOT NULL             |        | N/A               |                |会社名                                         |
| industry                    | varchar(255)  | utf8_general_ci      | NOT NULL             |        | N/A               |                |業界                                           |
| company_url                 | varchar(255)  | utf8_general_ci      | NOT NULL             |        | N/A               |                |会社URL                                        |
| zip1                        | int(11)       |                      | NOT NULL             |        | N/A               |                |会社画像その1                                   |
| zip2                        | int(11)       |                      | NOT NULL             |        | N/A               |                |会社画像その2                                   |
| zip3                        | int(11)       |                      | NOT NULL             |        | N/A               |                |会社画像その3                                   |
| location                    | varchar(255)  | utf8_general_ci      | NOT NULL             |        | N/A               |                |所在地                                         |
| number_of_employees         | int(11)       |                      | NOT NULL             |        | N/A               |                |従業員数                                       |
| year_of_establishment       | int(11)       |                      | NOT NULL             |        | N/A               |                |設立年度                                       |
| representative              | varchar(255)  | utf8_general_ci      | NOT NULL             |        | N/A               |                |代表者                                         |
| listed_year                 | int(11)       |                      | NOT NULL             |        | N/A               |                |上場年                                         |
| average_annual_income       | int(11)       |                      | NOT NULL             |        | N/A               |                |平均年収                                       |
| average_age                 | int(11)       |                      | NOT NULL             |        | N/A               |                |平均年齢                                       |
| number_of_reviews           | int(11)       |                      | NOT NULL             |        | N/A               |                |口コミ数                                       |
| delete_flg                  | tinyint(1)    |                      | NOT NULL             |        | N/A               |                |                                              |
| create_date                 | datetime      |                      | NOT NULL             |        | N/A               |                |                                              |
| update_date                 | timestamp     |                      | NOT NULL             |        | CURRENT_TIMESTAMP |                |                                              |

- **Relationship**

| Column name                     | Target table name             | Target column name | CASCADE                             |
|:--------------------------------|:------------------------------|:-------------------|:------------------------------------|
| t_delivery_plan_detail_split_id | t_delivery_plan_detail_splits | id                 | ON UPDATE CASCADE,ON DELETE CASCADE |



### report_category
- report_category(通報機能専用の項目関係のデータを管理する。)

| Field                       | Type          |Collation             |Nullable or NOT NULL  | Key    | Default           | Extra          | Description                                  |
|:----------------------------|:--------------|:---------------------|:---------------------|:-------|:------------------|:---------------|:---------------------------------------------|
| id                          | int(11)       |                      | NOT NULL             | UNIQUE | N/A               | auto_increment |                                              |
| name                        | int(11)       |                      | NOT NULL             |        | N/A               |                |                                              |
| delete_flg                  | tinyint(1)    |                      | NOT NULL             |        | N/A               |                |                                              |
| create_date                 | datetime      |                      | NOT NULL             |        | N/A               |                |                                              |
| update_date                 | timestamp     |                      | NOT NULL             |        | CURRENT_TIMESTAMP |                |                                              |


### browsing_history_relasions
- browsing_historys(一般ユーザーの閲覧履歴を管理する。)
  - users:browsing_historys_relasionsは1:1の関係となる
  - browsing_historys_relasions:employee_reviewsは1:nの関係となる
  - browsing_historys_relasions:browsing_historys_recodesは1:nの関係となる

| Field                       | Type          |Collation             |Nullable or NOT NULL  | Key    | Default           | Extra          | Description                                  |
|:----------------------------|:--------------|:---------------------|:---------------------|:-------|:------------------|:---------------|:---------------------------------------------|
| id                          | int(11)       |                      | NOT NULL             | UNIQUE | N/A               | auto_increment |                                              |
| user_id                     | int(11)       |                      | NOT NULL             |        | N/A               |                |                                              |
| employee_review_id          | int(11)       |                      | NOT NULL             |        | N/A               |                |                                              |
| browsing_historys_recode_id | int(11)       |                      | NOT NULL             |        | N/A               |                |                                              |
| delete_flg                  | tinyint(1)    |                      | NOT NULL             |        | N/A               |                |                                              |
| create_date                 | datetime      |                      | NOT NULL             |        | N/A               |                |                                              |
| update_date                 | timestamp     |                      | NOT NULL             |        | CURRENT_TIMESTAMP |                |                                              |

| Column name               | Target table name       | Target column name | CASCADE                             |
|:--------------------------|:------------------------|:-------------------|:------------------------------------|
| t_delivery_plan_detail_id | t_delivery_plan_details | id                 | ON UPDATE CASCADE,ON DELETE CASCADE |



### browsing_historys_recodes
- browsing_historys_recodes (閲覧履歴のログを管理する。)

| Field                       | Type          |Collation             |Nullable or NOT NULL  | Key    | Default           | Extra          | Description                                  |
|:----------------------------|:--------------|:---------------------|:---------------------|:-------|:------------------|:---------------|:---------------------------------------------|
| id                          | int(11)       |                      | NOT NULL             | UNIQUE | N/A               | auto_increment |                                              |
| browsing_historys_recode    | varchar(255)  |                      | NOT NULL             |        | N/A               |                |                                              |
| delete_flg                  | tinyint(1)    |                      | NOT NULL             |        | N/A               |                |                                              |
| create_date                 | datetime      |                      | NOT NULL             |        | N/A               |                |                                              |
| update_date                 | timestamp     |                      | NOT NULL             |        | CURRENT_TIMESTAMP |                |                                              |


## memo
- `varchar`はmigration fileでは`string`と定義
- `numeric`はmigration fileでは`Decimal`と定義
