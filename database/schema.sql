CREATE TABLE project (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) Engine=InnoDB;

CREATE TABLE task (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    status VARCHAR(16) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) Engine=InnoDB;

-- Add foreign key to task.project_id linking with project table
-- Add unsigned to project.id, task.id and task.project_id
-- task.status field is unused
-- Probably change task.status to one of number type and match with name from config(3 => closed)