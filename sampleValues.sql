INSERT INTO
    `teacher`(`name`, `last_name`)
VALUES
    ('Juan Manuel', 'Trejo Hernandez'),
    ('Ramon', 'Arreola Moreno'),
    ('Julia Adriana', 'Morales Avalos'),
    ('Maria Cecilia', 'Ruiz Vargas'),
    ('Diego', 'Andrés Garcia'),
    ('Mauro Leandro', 'Almaraz Cordoba'),
    ('Martín de Jesus', 'Tinajero Mendoza'),
    ('Guadalupe Karina', 'Beltran Martinez'),
    (
        'Beatriz Esquivel',
        '- Norma Angelica Martinez Martinez'
    ),
    ('Ignacio', 'Tinajero Camacho'),
    ('David', 'Martinez');

INSERT INTO
    `workshop`(
        `name`,
        `image_url`,
        `max_capacity`,
        `teacher_id`
    )
VALUES
    (
        'Futbol Femenil',
        '/assets/image/futbol_femenil.webp',
        '35',
        '2'
    ),
    (
        'Futbol Varonil',
        '/assets/image/futbol_varonil.webp',
        '35',
        '1'
    ),
    (
        'Pintura',
        '/assets/image/pintura.webp',
        '35',
        '3'
    ),
    (
        'Danza',
        '/assets/image/danza.webp',
        '35',
        '4'
    ),
    (
        'Ajedrez',
        '/assets/image/ajedrez.webp',
        '35',
        '5'
    ),
    (
        'Guitarra',
        '/assets/image/guitarra.webp',
        '35',
        '6'
    ),
    (
        'Basquetbol Varonil',
        '/assets/image/basquetbol_varonil.webp',
        '35',
        '7'
    ),
    (
        'Basquetbol Femenil',
        '/assets/image/basquetbol_femenil.webp',
        '35',
        '7'
    ),
    (
        'Bastoneras',
        '/assets/image/bastoneras.webp',
        '35',
        '8'
    ),
    (
        'Tabla Ritmica',
        '/assets/image/tabla_ritmica.webp',
        '35',
        '9'
    ),
    (
        'Robotica',
        '/assets/image/robotica.webp',
        '35',
        '10'
    ),
    (
        'Banda de Guerra',
        '/assets/image/banda_guerra.webp',
        '35',
        '11'
    );