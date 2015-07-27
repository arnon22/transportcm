CREATE TABLE transport_company_info (
    company_id INT(11) NOT NULL AUTO_INCREMENT,
    company_name varchar(255) NOT NULL,
    company_address1 varchar(255) NOT NULL,
    company_address2 varchar(255),
    company_city varchar(255),
    company_province varchar(255),
    company_postcode INT(11),
    company_tel varchar(10),
    company_fax varchar(10),
    company_tax_id varchar(255),
    create_date DATE,
    modified_date DATE,
    PRIMARY KEY(company_id)   
)charset =UTF8;

INSERT INTO transport_company_info (NULL,'บริษัท ธ.นุชาพร จำกัด','',,,,,,,,,,,)