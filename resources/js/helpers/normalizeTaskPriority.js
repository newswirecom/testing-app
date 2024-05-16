import TaskPriorityEnum from "@/Enums/TaskPriorityEnum.ts";

const normalizeTaskPriority = {
    [TaskPriorityEnum.LOW]: 'Low',
    [TaskPriorityEnum.MEDIUM]: 'Medium',
    [TaskPriorityEnum.HIGH]: 'High',
}

export default normalizeTaskPriority;
