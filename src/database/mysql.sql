--
-- Table structure for table "product"
--

CREATE TABLE "products" (
  "id" int NOT NULL PRIMARY KEY ,
  "title" varchar NOT NULL,
  "description" varchar NOT NULL,
  "image_url" varchar,
  "created_at" timestamp NOT NULL DEFAULT now(),
  "updated_at" timestamp NULL DEFAULT NULL
);