import TaskStatusEnum from "@/Enums/TaskStatusEnum.ts";

const normalizeTaskStatus = {
    [TaskStatusEnum.OPEN]: 'Open',
    [TaskStatusEnum.IN_PROGRESS]: 'In Progress',
    [TaskStatusEnum.COMPLETED]: 'Completed',
}

export default normalizeTaskStatus;
