-- Agregar columnas para llegadas tarde en la tabla de asistencia
ALTER TABLE attendance
ADD COLUMN arrival_time TIME NULL,
ADD COLUMN is_late TINYINT(1) DEFAULT 0;

-- Tabla para notificaciones
CREATE TABLE IF NOT EXISTS notifications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    type VARCHAR(50) NOT NULL,
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabla para notificaciones masivas
CREATE TABLE IF NOT EXISTS mass_notifications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    sender_id INT NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    recipient_type VARCHAR(50) NOT NULL,
    course_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE SET NULL
);

-- Tabla para destinatarios de notificaciones masivas
CREATE TABLE IF NOT EXISTS mass_notification_recipients (
    notification_id INT NOT NULL,
    user_id INT NOT NULL,
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (notification_id, user_id),
    FOREIGN KEY (notification_id) REFERENCES mass_notifications(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabla para configuración de notificaciones por usuario
CREATE TABLE IF NOT EXISTS notification_settings (
    user_id INT PRIMARY KEY,
    email_attendance TINYINT(1) DEFAULT 1,
    email_late_arrival TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabla para registro de actividades
CREATE TABLE IF NOT EXISTS activity_log (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    action VARCHAR(100) NOT NULL,
    description TEXT NULL,
    ip_address VARCHAR(45) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Índices para optimizar consultas
CREATE INDEX idx_attendance_date ON attendance(date);
CREATE INDEX idx_attendance_student ON attendance(student_id);
CREATE INDEX idx_attendance_subject ON attendance(subject_id);
CREATE INDEX idx_notifications_user ON notifications(user_id);
CREATE INDEX idx_notifications_type ON notifications(type);
CREATE INDEX idx_mass_notifications_type ON mass_notifications(recipient_type);
CREATE INDEX idx_mass_notifications_course ON mass_notifications(course_id);
CREATE INDEX idx_activity_log_user ON activity_log(user_id);
CREATE INDEX idx_activity_log_action ON activity_log(action);
CREATE INDEX idx_activity_log_date ON activity_log(created_at);

-- Trigger para registrar actividad al crear una notificación masiva
DELIMITER //
CREATE TRIGGER after_mass_notification_insert
AFTER INSERT ON mass_notifications
FOR EACH ROW
BEGIN
    INSERT INTO activity_log (user_id, action, description)
    VALUES (NEW.sender_id, 'send_mass_notification', CONCAT('Envió notificación masiva: ', NEW.subject));
END;
//
DELIMITER ;

-- Trigger para registrar actividad al marcar asistencia
DELIMITER //
CREATE TRIGGER after_attendance_insert
AFTER INSERT ON attendance
FOR EACH ROW
BEGIN
    DECLARE student_name VARCHAR(255);
    DECLARE subject_name VARCHAR(255);
    
    SELECT CONCAT(first_name, ' ', last_name) INTO student_name
    FROM students WHERE id = NEW.student_id;
    
    SELECT name INTO subject_name
    FROM subjects WHERE id = NEW.subject_id;
    
    INSERT INTO activity_log (user_id, action, description)
    VALUES (
        (SELECT user_id FROM sessions WHERE id = (SELECT MAX(id) FROM sessions)),
        'mark_attendance',
        CONCAT(
            'Marcó a ', 
            student_name, 
            ' como ', 
            IF(NEW.is_present, 'presente', 'ausente'),
            IF(NEW.is_late, ' (llegada tarde)', ''),
            ' en ', 
            subject_name
        )
    );
END;
//
DELIMITER ;
